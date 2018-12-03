($ => {
  ko = window.ko || {};

  function ObservableReview(properties) {
    for (let i in properties) {
      this[i] = ko.observable(properties[i]);
    }
  }

  const observableListOfReviews = list => {
    return list.map(i => new ObservableReview(i));
  };

  const fetchReviews = (page, limit, id, user_id) => {
    let url = `/wp-json/brainworks/reviews/get?page=${page}&limit=${limit}&post_id=${id}&user_id=${user_id}`;
    return fetch(url).then(response => response.json());
  };

  const inc = n => ++n;

  function ReviewsViewModel(post_id, user_id, post_type) {
    const _this = this;

    const isMoreReviews = (page, limit, count) => page * limit <= count;

    _this.reviews = ko.observableArray([]);
    _this.totalCount = ko.observable(0);
    _this.loading = false;
    _this.hasMoreReviews = ko.observable(false);
    _this.page = ko.observable(1);
    _this.limit = 10;
    _this.post_id = post_id;
    _this.currentLikes = ko.observable({});
    _this.showModal = ko.observable(false);

    _this.getReviews = () => {
      return fetchReviews(_this.page(), _this.limit, _this.post_id, user_id);
    };

    let setLike = (review_id, isPositive = 1) => {
      return new Promise(resolve => {
        $.post("/wp-json/brainworks/reviews/like", {
          post_id: review_id,
          user_id,
          post_type,
          value: isPositive
        }).success(response => resolve(response));
      });
    };

    _this.hideModal = () => {
      _this.showModal(false);
    }

    _this.likePost = (isPositive, review_id) => {
      if (user_id == 0)
      {
        _this.showModal(true);
        return;
      }
      _this.reviews = ko.observableArray(
        _this.reviews().map(i => {
          if (i.ID == review_id) i.liked(true);
          return i;
        })
      );
      setLike(review_id, isPositive);
    };

    _this.loadMore = () => {
      _this.getReviews().then(json => {
        let { data, count } = json;
        if (data && count) {
          _this.reviews(
            _this.reviews().concat(
              observableListOfReviews(
                data.map(i => {
                  i.replyForm = false;
                  return i;
                })
              )
            )
          );
          _this.page(inc(_this.page()));
          _this.totalCount(+count);
          _this.hasMoreReviews(
            isMoreReviews(_this.page(), _this.limit, _this.totalCount())
          );
        }
      });
    };

    _this.getReviews().then(json => {
      let { data, count } = json;
      if (data && count) {
        _this.reviews(
          observableListOfReviews(
            data.map(i => {
              i.replyForm = false;
              return i;
            })
          )
        );
        _this.page(inc(_this.page()));
        _this.totalCount(+count);
        _this.hasMoreReviews(
          isMoreReviews(_this.page(), _this.limit, _this.totalCount())
        );
      }
    });
  }

  ko.components.register("rating", {
    viewModel: function(params) {
      let rating = Math.floor(params.count());
      this.activeStars = rating;
      this.emptyStars = 5 - this.activeStars;
      this.value = params.count();
    },
    template: `
            <div class="review-rating">
              <span data-bind="foreach: new Array(activeStars)"><i class="fa fa-star"></i></span>
              <span data-bind="foreach: new Array(emptyStars)"><i class="fal fa-star"></i></span>
              <span data-bind="text: value + ' из 5'"></span>
            </div>
        `
  });

  ko.components.register("review-form-stars", {
    viewModel: function(params) {
      let _this = this;
      let $rating = $(".rating-input-ko");
      let description = {
        1: "Очень плохо",
        2: "Плохо",
        3: "Неплохо",
        4: "Хорошо",
        5: "Отлично"
      };
      _this.choosed = ko.observable(0);
      _this.onChange = params.onChange || (() => {});
      _this.maximum = 5;
      _this.clicked = ko.observable(false);

      setTimeout(() => {
        let labels = $(".rating-input-ko label");
        labels
          .each((index, label) => {
            let $label = $(label);

            $label.on("mouseover click", e => {
              if (e.type === "click") {
                let value = 1 * $("#" + $label.attr("for")).val() + 1;
                _this.choosed(value);
                _this.onChange(value, description[value]);
                _this.clicked(true);
              }
              labels.each((innerIndex, innerLabel) => {
                _this.onChange(0, description[index + 1]);
                if (innerIndex <= index) {
                  $(innerLabel)
                    .find("i")
                    .removeClass("fal")
                    .addClass("fa");
                } else {
                  $(innerLabel)
                    .find("i")
                    .removeClass("fa")
                    .addClass("fal");
                }
              });
            });
          })
          .on("mouseout", e => {
            if (_this.clicked() === false) {
              labels
                .find("i")
                .removeClass("fa")
                .addClass("fal");
            } else {
              labels.each((index, label) => {
                if (index + 1 <= _this.choosed()) {
                  $(label)
                    .find("i")
                    .addClass("fa")
                    .removeClass("fal");
                } else {
                  $(label)
                    .find("i")
                    .addClass("fal")
                    .removeClass("fa");
                }
              });

              _this.onChange(_this.choosed(), description[_this.choosed()]);
            }
          });
      }, 10);
    },
    template: `
    <div class="rating-input rating-input-ko" data-bind="foreach: new Array(maximum)">
      <label data-bind="attr: {for: 'rating_' + $index()}"><i class="fal fa-star"></i></label>
      <input data-bind="attr: {id: 'rating_' + $index(), value: $index()}" type="radio" name="rating" style="display: none">
    </div>
    `
  });

  ko.components.register("review-form", {
    viewModel: function(params) {
      let _this = this;
      _this.apiURL = "/wp-json/brainworks/reviews/add";
      let requiredParams = {
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
      _this.onChangeStars = (star, description) => {
        _this.rating(star);
        _this.ratingDescription(description);
      };

      _this.submit = e => {
        console.log(e);
        const data = {};
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
        for (let j in requiredParams) {
          data[j] = requiredParams[j];
        }
        data.content = _this.content();
        _this.error(false);
        $.post("/wp-json/brainworks/reviews/add", data).done(response => {
          if (response.success == true) {
            $(".review-form").remove();
            _this.success(true);
          }
        });
      };
    },
    template: `
      <div>
        <div data-bind="if: error()">
          <div class="alert-error" data-bind="text: error()"></div>
        </div>
        <form class="review-form" data-bind="event: {submit: submit}">
          <div data-bind="if: hasRating">
            <label>Ваша оценка:</label>
            <div>
              <review-form-stars params="onChange: onChangeStars"></review-form-stars>
              &nbsp;
              <span data-bind="text: ratingDescription"></span>
            </div>
          </div>
          <div>
            <label for="review_content">Ваш отзыв:</label>
            <div>
            <textarea data-bind="value: content" placeholder="Введите Ваш отзыв..."></textarea>
            </div>
          </div>
          <div>
            <label></label>
            <div>
            <button type="submit" class="button-alt">Отправить</button>
            </div>
          </div>
        </form>
        <div data-bind="if: success()">
          Вы успешно отправили Ваш отзыв и получили +10 к репутации!
        </div>
      </div>
    `
  });

  $(document).ready(() => {
    let rootElement = $("#reviews_list"),
      post_id = rootElement.attr("data-id"),
      user_id = rootElement.attr("data-user"),
      post_type = rootElement.attr("data-type");
    ko.applyBindings(new ReviewsViewModel(post_id, user_id, post_type));
  });
})(jQuery);
