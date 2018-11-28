"use strict";

function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread();
}

function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance");
}

function _iterableToArray(iter) {
    if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter);
}

function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) {
        for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) {
            arr2[i] = arr[i];
        }
        return arr2;
    }
}

function _objectSpread(target) {
    for (var i = 1; i < arguments.length; i++) {
        var source = arguments[i] != null ? arguments[i] : {};
        var ownKeys = Object.keys(source);
        if (typeof Object.getOwnPropertySymbols === "function") {
            ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function(sym) {
                return Object.getOwnPropertyDescriptor(source, sym).enumerable;
            }));
        }
        ownKeys.forEach(function(key) {
            _defineProperty(target, key, source[key]);
        });
    }
    return target;
}

function _defineProperty(obj, key, value) {
    if (key in obj) {
        Object.defineProperty(obj, key, {
            value: value,
            enumerable: true,
            configurable: true,
            writable: true
        });
    } else {
        obj[key] = value;
    }
    return obj;
}

function _typeof(obj) {
    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
        _typeof = function _typeof(obj) {
            return typeof obj;
        };
    } else {
        _typeof = function _typeof(obj) {
            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
        };
    }
    return _typeof(obj);
}

(function($) {
    var rootElement = $("#reviews_list"), loadMoreElement = $(".load-more");
    var Config = {
        PostID: rootElement.attr("data-id"),
        Theme: "/wp-content/themes/rc-v1.0"
    };
    var ApiService = {
        Links: {
            GetReviews: "/wp-json/brainworks/reviews/get"
        },
        Methods: {
            GetLink: function GetLink(linkKey, params) {
                var link = ApiService.Links[linkKey] || "";
                if (!link) return false;
                if (_typeof(params) === "object") {
                    link += "?";
                    for (var j in params) {
                        link += "".concat(j, "=").concat(params[j], "&");
                    }
                    link = link.slice(0, link.length - 1);
                }
                return link;
            }
        }
    };
    var Actions = {
        FETCH_REVIEWS_START: "FETCH_REVIEWS_START",
        FETCH_REVIEWS_END: "FETCH_REVIEWS_END",
        FETCH_REVIEWS_ERROR: "FETCH_REVIEWS_ERROR",
        INCREMENT_REVIEWS_PAGE: "INCREMENT_REVIEWS_PAGE",
        FETCH_REVIEWS_REPLIES_START: "FETCH_REVIEWS_REPLIES_START",
        FETCH_REVIEWS_REPLIES_END: "FETCH_REVIEWS_REPLIES_END",
        REVIEWS_LOAD_MORE: "REVIEWS_LOAD_MORE",
        REVIEWS_LOAD_MORE_END: "REVIEWS_LOAD_MORE_END"
    };
    var initialState = {
        fetching: false,
        fetched: false,
        data: [],
        page: 1,
        postsPerPage: 1,
        error: false,
        fetchingReplies: false,
        currentReview: 0,
        count: 0
    };
    function reducer() {
        var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : initialState;
        var action = arguments.length > 1 ? arguments[1] : undefined;
        switch (action.type) {
          case Actions.FETCH_REVIEWS_START:
            return _objectSpread({}, state, {
                fetching: true
            });

          case Actions.FETCH_REVIEWS_END:
            return _objectSpread({}, state, {
                fetching: false,
                data: action.payload.data || [],
                count: action.payload.count
            });

          case Actions.FETCH_REVIEWS_ERROR:
            return _objectSpread({}, state, {
                fetching: false,
                error: true
            });

          case Actions.REVIEWS_LOAD_MORE:
            return _objectSpread({}, state, {
                fetchingMore: true,
                fetchedMore: false,
                page: state.page + 1
            });

          case Actions.REVIEWS_LOAD_MORE_END:
            return _objectSpread({}, state, {
                fetchingMore: false,
                fetchedMore: true,
                data: _toConsumableArray(state.data).concat([ action.payload ])
            });

          default:
            return state;
        }
    }
    var store = Redux.createStore(reducer);
    store.subscribe(function() {
        var state = store.getState();
        if (state.fetching === true && state.fetched === false || state.fetchingMore === true && state.fetchedMore === false) {
            rootElement.append(ReviewsList.loader.insert()).addClass("loading");
        } else {
            rootElement.removeClass("loading");
            ReviewsList.loader.remove();
        }
        if (state.error !== false) {
            rootElement.addClass("errored").append($("<img />").attr("src", Config.Theme + "/assets/img/error.svg").css("width", "60px").css("height", "60px"));
        }
        if (state.page * state.postsPerPage >= state.count && state.count != 0) {
            loadMoreElement.remove();
        }
    });
    var ReviewsList = function() {
        var getReviews = function getReviews(page, postsPerPage) {
            return new Promise(function(resolve, reject) {
                $.get(ApiService.Methods.GetLink("GetReviews", {
                    page: page,
                    limit: postsPerPage,
                    post_id: Config.PostID
                })).done(function(response) {
                    resolve(response);
                }).fail(function() {
                    reject();
                });
            });
        };
        return {
            init: function init() {
                var _this2 = this;
                var state = store.getState(), _this = this;
                store.dispatch({
                    type: Actions.FETCH_REVIEWS_START
                });
                getReviews(state.page, state.postsPerPage).then(function(response) {
                    var data = response.data;
                    loadMoreElement.show().on("click", _this.loadMore.bind(_this));
                    _this2.reviews.appendMany(data);
                    store.dispatch({
                        type: Actions.FETCH_REVIEWS_END,
                        payload: {
                            data: data,
                            count: +response.count
                        }
                    });
                }).catch(function(error) {
                    return store.dispatch({
                        type: Actions.FETCH_REVIEWS_ERROR
                    });
                });
            },
            loadMore: function loadMore() {
                var state = store.getState(), _this = this, page = state.page + 1;
                store.dispatch({
                    type: Actions.REVIEWS_LOAD_MORE
                });
                getReviews(page, state.postsPerPage).then(function(response) {
                    var data = response.data;
                    _this.reviews.appendMany(data);
                    store.dispatch({
                        type: Actions.REVIEWS_LOAD_MORE_END,
                        payload: data
                    });
                });
            },
            loader: {
                $element: $("<div />").addClass("loader").append($("<img />").attr("src", Config.Theme + "/assets/img/loader.gif").css("width", "90px").css("height", "90px")),
                currentElement: null,
                insert: function insert() {
                    return this.currentElement = this.$element.clone();
                },
                remove: function remove() {
                    return this.currentElement.remove();
                }
            },
            reviews: {
                reviewTemplate: function reviewTemplate(item) {
                    var container = $("<div />").addClass("r-review-item");
                    $("<div />").addClass("review-thumbnail-container").append($("<img />").attr("src", item.user_image)).appendTo(container);
                    var contentContainer = $("<div />").addClass("review-content-container").appendTo(container), contentHeader = $("<div />").addClass("review-item-header");
                    contentHeader.append($("<a />").attr("href", item.user_link).attr("target", "_blank").text(item.user_name)).append($("<small />").addClass("review-item-date").text(item.post_date)).appendTo(contentContainer);
                    contentContainer.append($("<div />").addClass("review-rating").html(function() {
                        var output = "";
                        for (var i = 1; i <= 5; i++) {
                            var className = "fa fa-star";
                            if (i > item.rating) {
                                className = "fal fa-star";
                            }
                            output += '<i class="'.concat(className, '"></i>');
                        }
                        output += "&nbsp;<span>".concat(item.rating, " из 5</span>");
                        return output;
                    }())).append($("<div />").addClass("review-item-content").html(item.post_content));
                    return container.clone();
                },
                appendMany: function appendMany(data) {
                    var _this3 = this;
                    data.map(function(item) {
                        var review = _this3.reviewTemplate(item);
                        rootElement.append(review);
                    });
                }
            }
        };
    }();
    $(document).ready(function() {
        ReviewsList.init();
    });
})(jQuery);