(($) => {

    const rootElement = $("#reviews_list"),
        loadMoreElement = $(".load-more");

    const Config = {
        PostID: rootElement.attr('data-id'),
        Theme: "/wp-content/themes/rc-v1.0"
    }; 


    const ApiService = {
        Links: {
            GetReviews: "/wp-json/brainworks/reviews/get"
        },
        Methods: {
            GetLink: (linkKey, params) => {
                let link = ApiService.Links[linkKey] || "";
                if (!link) return false;
                if (typeof params === "object")
                {
                    link += "?";
                    for (let j in params)
                    {
                        link += `${j}=${params[j]}&`;
                    }
                    link = link.slice(0, link.length-1);
                }
                return link;
            }
        }
    };

    const Actions = {
        FETCH_REVIEWS_START: "FETCH_REVIEWS_START",
        FETCH_REVIEWS_END: "FETCH_REVIEWS_END",
        FETCH_REVIEWS_ERROR: "FETCH_REVIEWS_ERROR",
        INCREMENT_REVIEWS_PAGE: "INCREMENT_REVIEWS_PAGE",
        FETCH_REVIEWS_REPLIES_START: "FETCH_REVIEWS_REPLIES_START",
        FETCH_REVIEWS_REPLIES_END: "FETCH_REVIEWS_REPLIES_END",
        REVIEWS_LOAD_MORE: "REVIEWS_LOAD_MORE",
        REVIEWS_LOAD_MORE_END: "REVIEWS_LOAD_MORE_END"
    };
    
    const initialState = {
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

    function reducer (state = initialState, action)
    {
        switch(action.type)
        {
            case Actions.FETCH_REVIEWS_START: 
                return {...state, fetching: true};
            case Actions.FETCH_REVIEWS_END:
                return {...state, fetching: false, data: action.payload.data || [], count: action.payload.count};
            case Actions.FETCH_REVIEWS_ERROR:
                return {...state, fetching: false, error: true};
            case Actions.REVIEWS_LOAD_MORE:
                return {...state, fetchingMore: true, fetchedMore: false, page: state.page + 1};
            case Actions.REVIEWS_LOAD_MORE_END: 
                return {...state, fetchingMore: false, fetchedMore: true, data: [...state.data, action.payload]};
            default:
                return state;
        }
    }

    const store = Redux.createStore(reducer);

    store.subscribe(() => {
        const state = store.getState();

        if (state.fetching === true && state.fetched === false
            || state.fetchingMore === true && state.fetchedMore === false)
        {
            rootElement.append(ReviewsList.loader.insert()).addClass("loading");
        }
        else
        {
            rootElement.removeClass("loading");
            ReviewsList.loader.remove();
        }

        if (state.error !== false)
        {
            rootElement
                .addClass("errored")
                .append($("<img />")
                .attr("src", Config.Theme + "/assets/img/error.svg")
                .css("width", "60px")
                .css("height", "60px"))
        }
        if (state.page * state.postsPerPage >= state.count && state.count != 0)
        {
            loadMoreElement.remove();
        }
    });

    const ReviewsList = (() => {
        const getReviews = (page, postsPerPage) => {
            return new Promise((resolve, reject) => {
                $.get(ApiService.Methods.GetLink("GetReviews", { 
                    page: page,
                    limit: postsPerPage,
                    post_id: Config.PostID
                }))
                    .done(response => {
                        resolve(response);
                    })
                    .fail(() => {
                        reject();
                    });
            });
        }
        return {
            init: function () {
                let state = store.getState(),
                    _this = this;
                store.dispatch({type: Actions.FETCH_REVIEWS_START});
                getReviews(state.page, state.postsPerPage)
                    .then(response => {
                        let data = response.data;
                        loadMoreElement.show()
                            .on("click", _this.loadMore.bind(_this));
                        this.reviews.appendMany(data);
                        store.dispatch({type: Actions.FETCH_REVIEWS_END, payload: {data: data, count: +response.count}});
                    }).catch(error => store.dispatch({type: Actions.FETCH_REVIEWS_ERROR}));
            },
            loadMore: function () {
                let state = store.getState(),
                    _this = this,
                    page  = state.page + 1;
                store.dispatch({type: Actions.REVIEWS_LOAD_MORE});
                getReviews(page, state.postsPerPage)
                    .then(response => {
                        let data = response.data;
                        _this.reviews.appendMany(data);
                        store.dispatch({type: Actions.REVIEWS_LOAD_MORE_END, payload: data});
                    });
            },
            loader: {
                $element: $("<div />")
                    .addClass("loader")
                    .append($("<img />")
                    .attr("src", Config.Theme + "/assets/img/loader.gif")
                    .css("width", "90px")
                    .css("height", "90px")),
                currentElement: null,
                insert: function () {
                    return this.currentElement = this.$element.clone();
                },
                remove: function () {
                    return this.currentElement.remove();
                }
            },
            reviews: {
                reviewTemplate: (function (item) {
                    let container = $("<div />").addClass("r-review-item");
                    
                    $("<div />").addClass("review-thumbnail-container")
                        .append($("<img />").attr("src", item.user_image))
                        .appendTo(container);

                    let contentContainer = $("<div />").addClass("review-content-container")
                        .appendTo(container),
                        contentHeader = $("<div />").addClass("review-item-header");
                    
                    contentHeader.append(
                        $("<a />").attr("href", item.user_link)
                                .attr("target", "_blank")
                                .text(item.user_name)
                    ).append(
                        $("<small />").addClass("review-item-date").text(item.post_date)
                    ).appendTo(contentContainer);

                    contentContainer.append(
                        $("<div />").addClass("review-rating")
                            .html((() => {
                                let output = "";
                                for (let i = 1; i <= 5; i++)
                                {
                                    let className = "fa fa-star";
                                    if (i > item.rating)
                                    {
                                        className = "fal fa-star";
                                    }
                                    output += `<i class="${className}"></i>`;
                                }
                                output += `&nbsp;<span>${item.rating} из 5</span>`;
                                return output;
                            })())
                    ).append(
                        $("<div />").addClass("review-item-content")
                            .html(item.post_content)
                    )

                    return container.clone();
                }),
                appendMany: function (data) {
                    data.map(item => {
                        let review = this.reviewTemplate(item);
                        
                        rootElement.append(review);
                    }); 
                }
            }
        };  
    })();

    $(document).ready(() => {ReviewsList.init()});

})(jQuery);