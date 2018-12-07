"use strict";

(function($) {
    ko = window.ko || {};
    function ObservableReview(properties) {
        for (var i in properties) {
            this[i] = ko.observable(properties[i]);
        }
    }
    var observableListOfReviews = function observableListOfReviews(list) {
        return list.map(function(i) {
            return new ObservableReview(i);
        });
    };
    var fetchReviews = function fetchReviews(page, limit, id, user_id) {
        var url = "/wp-json/brainworks/reviews/get?page=".concat(page, "&limit=").concat(limit, "&post_id=").concat(id, "&user_id=").concat(user_id);
        return fetch(url).then(function(response) {
            return response.json();
        });
    };
    var inc = function inc(n) {
        return ++n;
    };
    function ReviewsViewModel(post_id, user_id, post_type) {
        var _this = this;
        var isMoreReviews = function isMoreReviews(page, limit, count) {
            return (page - 1) * limit <= count;
        };
        _this.reviews = ko.observableArray([]);
        _this.totalCount = ko.observable(0);
        _this.loading = false;
        _this.hasMoreReviews = ko.observable(false);
        _this.page = ko.observable(1);
        _this.limit = 4;
        _this.post_id = post_id;
        _this.currentLikes = ko.observable({});
        _this.showModal = ko.observable(false);
        _this.getReviews = function() {
            return fetchReviews(_this.page(), _this.limit, _this.post_id, user_id);
        };
        var setLike = function setLike(review_id) {
            var isPositive = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
            return new Promise(function(resolve) {
                $.post("/wp-json/brainworks/reviews/like", {
                    post_id: review_id,
                    user_id: user_id,
                    post_type: post_type,
                    value: isPositive
                }).success(function(response) {
                    return resolve(response);
                });
            });
        };
        _this.hideModal = function() {
            _this.showModal(false);
        };
        _this.likePost = function(isPositive, review_id) {
            if (user_id == 0) {
                _this.showModal(true);
                return;
            }
            _this.reviews = ko.observableArray(_this.reviews().map(function(i) {
                if (i.ID == review_id) i.liked(true);
                return i;
            }));
            setLike(review_id, isPositive);
        };
        _this.loadMore = function() {
            _this.getReviews().then(function(json) {
                var data = json.data, count = json.count;
                if (data && count) {
                    _this.reviews(_this.reviews().concat(observableListOfReviews(data.map(function(i) {
                        i.replyForm = false;
                        return i;
                    }))));
                    _this.page(inc(_this.page()));
                    _this.totalCount(+count);
                    _this.hasMoreReviews(isMoreReviews(_this.page(), _this.limit, _this.totalCount()));
                }
            });
        };
        _this.getReviews().then(function(json) {
            var data = json.data, count = json.count;
            if (data && count) {
                _this.reviews(observableListOfReviews(data.map(function(i) {
                    i.replyForm = false;
                    return i;
                })));
                _this.page(inc(_this.page()));
                _this.totalCount(+count);
                _this.hasMoreReviews(isMoreReviews(_this.page(), _this.limit, _this.totalCount()));
            }
        });
    }
    ko.components.register("rating", {
        viewModel: function viewModel(params) {
            var count = params.count;
            if (typeof params.count === "function") {
                count = params.count();
            }
            var rating = Math.floor(count);
            this.activeStars = rating;
            this.emptyStars = 5 - this.activeStars;
            this.value = count;
        },
        template: '\n            <div class="review-rating">\n              <span data-bind="foreach: new Array(activeStars)"><i class="fa fa-star"></i></span>\n              <span data-bind="foreach: new Array(emptyStars)"><i class="fal fa-star"></i></span>\n              <span data-bind="text: value + \' из 5\'"></span>\n            </div>  \n        '
    });
    ko.components.register("review-form-stars", {
        viewModel: function viewModel(params) {
            var _this = this;
            var $rating = $(".rating-input-ko");
            var description = {
                1: "Очень плохо",
                2: "Плохо",
                3: "Неплохо",
                4: "Хорошо",
                5: "Отлично"
            };
            _this.choosed = ko.observable(0);
            _this.onChange = params.onChange || function() {};
            _this.maximum = 5;
            _this.clicked = ko.observable(false);
            setTimeout(function() {
                var labels = $(".rating-input-ko label");
                labels.each(function(index, label) {
                    var $label = $(label);
                    $label.on("mouseover click", function(e) {
                        if (e.type === "click") {
                            var value = 1 * $("#" + $label.attr("for")).val() + 1;
                            _this.choosed(value);
                            _this.onChange(value, description[value]);
                            _this.clicked(true);
                        }
                        labels.each(function(innerIndex, innerLabel) {
                            _this.onChange(0, description[index + 1]);
                            if (innerIndex <= index) {
                                $(innerLabel).find("i").removeClass("fal").addClass("fa");
                            } else {
                                $(innerLabel).find("i").removeClass("fa").addClass("fal");
                            }
                        });
                    });
                }).on("mouseout", function(e) {
                    if (_this.clicked() === false) {
                        labels.find("i").removeClass("fa").addClass("fal");
                    } else {
                        labels.each(function(index, label) {
                            if (index + 1 <= _this.choosed()) {
                                $(label).find("i").addClass("fa").removeClass("fal");
                            } else {
                                $(label).find("i").addClass("fal").removeClass("fa");
                            }
                        });
                        _this.onChange(_this.choosed(), description[_this.choosed()]);
                    }
                });
            }, 10);
        },
        template: '\n    <div class="rating-input rating-input-ko" data-bind="foreach: new Array(maximum)">\n      <label data-bind="attr: {for: \'rating_\' + $index()}"><i class="fal fa-star"></i></label>\n      <input data-bind="attr: {id: \'rating_\' + $index(), value: $index()}" type="radio" name="rating" style="display: none">\n    </div>\n    '
    });
    ko.components.register("review-form", {
        viewModel: function viewModel(params) {
            var _this = this;
            _this.apiURL = "/wp-json/brainworks/reviews/add";
            var requiredParams = {
                post_id: params.post_id,
                user_id: params.user_id,
                user_pass: params.user_pass,
                reply_to: params.reply_to
            };
            _this.hasRating = params.rating || false;
            _this.rating = ko.observable(0);
            _this.ratingDescription = ko.observable("");
            _this.sent = ko.observable(false);
            _this.content = ko.observable("");
            _this.success = ko.observable(false);
            _this.error = ko.observable("");
            _this.onChangeStars = function(star, description) {
                _this.rating(star);
                _this.ratingDescription(description);
            };
            _this.submit = function(e) {
                console.log(e);
                var data = {};
                if (_this.hasRating && _this.rating() === 0) {
                    _this.error("Укажите, пожалуйста, Вашу оценку");
                    return;
                } else {
                    data.rating = _this.rating();
                }
                if (!_this.content()) {
                    _this.error("Пожалуйста, введите Ваш отзыв в поле ввода");
                    return;
                }
                for (var j in requiredParams) {
                    data[j] = requiredParams[j];
                }
                data.content = _this.content();
                _this.error(false);
                $.post("/wp-json/brainworks/reviews/add", data).done(function(response) {
                    if (response.success == true) {
                        $(".review-form").remove();
                        _this.success(true);
                    }
                });
            };
        },
        template: '\n      <div>\n        <div data-bind="if: error()">\n          <div class="alert-error" data-bind="text: error()"></div>\n        </div>\n        <form class="review-form" data-bind="event: {submit: submit}">\n          <div data-bind="if: hasRating">\n            <label>Ваша оценка:</label>\n            <div>\n              <review-form-stars params="onChange: onChangeStars"></review-form-stars>\n              &nbsp;\n              <span data-bind="text: ratingDescription"></span>\n            </div>\n          </div>\n          <div>\n            <label for="review_content">Ваш отзыв:</label>\n            <div>\n            <textarea data-bind="value: content" placeholder="Введите Ваш отзыв..."></textarea>\n            </div>\n          </div>\n          <div>\n            <label></label>\n            <div>\n            <button type="submit" class="button-alt">Отправить</button>\n            </div>\n          </div>\n        </form>\n        <div data-bind="if: success()">\n          Вы успешно отправили Ваш отзыв и получили +10 к репутации!\n        </div>\n      </div>\n    '
    });
    $(document).ready(function() {
        var rootElement = $("#reviews_list"), post_id = rootElement.attr("data-id"), user_id = rootElement.attr("data-user"), post_type = rootElement.attr("data-type");
        ko.applyBindings(new ReviewsViewModel(post_id, user_id, post_type));
        $(".review-like-modal").css("display", "block");
    });
})(jQuery);