<template>
    <v-card flat>
        <v-toolbar color="primary" dark extended flat>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
        </v-toolbar>

        <v-card class="mx-auto" max-width="700" style="margin-top: -64px;">
            <v-toolbar color="primary" dark flat height="auto">
                <v-container class="px-0">
                    <v-row no-gutters>
                        <v-col cols="12" md="4">
                            <v-select
                                v-model="filter.category"
                                :items="categories"
                                :menu-props="{ offsetY: true, contentClass: 'primary' }"
                                color="white"
                                hide-details
                                label="Category"
                                outlined
                                prepend-inner-icon="mdi-view-dashboard"
                            />
                        </v-col>

                        <v-col cols="12" md="4" offset-md="4">
                            <v-text-field
                                v-model="filter.search"
                                append-icon="mdi-magnify"
                                clearable
                                color="white"
                                hide-details
                                label="Search..."
                                outlined
                                single-line
                                type="search"
                            />
                        </v-col>
                    </v-row>
                </v-container>
            </v-toolbar>

            <v-divider></v-divider>

            <v-container fluid>
                <v-row dense>
                    <v-col :if="!loadFeed" v-for="feed in feedsData.feeds" :key="feed.id" cols="6">
                        <v-card>
                            <v-img
                                :if="feed.media"
                                :src="feed.media"
                                class="white--text align-end"
                                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                height="200px"
                            >
                                <v-card-title v-html="feed.title"></v-card-title>
                            </v-img>

                            <v-card-actions>
                                <v-list-item-content>
                                 <v-list-item-title>{{feed.categoryTitle}}</v-list-item-title>
                                </v-list-item-content>
                                <v-spacer></v-spacer>

                                <v-btn icon>
                                    <v-icon>mdi-heart</v-icon>
                                </v-btn>

                                <v-btn icon>
                                    <v-icon>mdi-bookmark</v-icon>
                                </v-btn>

                                <v-btn icon>
                                    <v-icon>mdi-share-variant</v-icon>
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>

            <v-container :if="feedsData.total > 10">
                <v-pagination
                    v-model="page"
                    :total-visible=6
                    :length=feedsData.total/10
                    @input="getFeeds()"
                ></v-pagination>
            </v-container>
        </v-card>
    </v-card>
</template>

<script>
export default {
    data: function() {
        return {
            filter: {
                category: null,
                search: '',
            },
            loadFeed: true,
            page: 1,
            categories: [],
            feedsData: {
                feeds: [],
                total: 0,
            },
            cards: [
                {
                    title: 'Pre-fab homes',
                    src: 'https://cdn.vuetifyjs.com/images/cards/house.jpg',
                    flex: 12,
                },
                {
                    title: 'Favorite road trips',
                    src: 'https://cdn.vuetifyjs.com/images/cards/road.jpg',
                    flex: 6,
                },
                {
                    title: 'Best airlines',
                    src: 'https://cdn.vuetifyjs.com/images/cards/plane.jpg',
                    flex: 6,
                },
            ],
        }
    },
    methods: {
        getFeeds() {
            const app = this
            app.feedsData = {
                feeds: [],
                total: 0,
            };
            app.loadFeed = true;
            const skip = ((app.page-1) * 10)

            axios
                .get('/api/v1/feeds?skip='+skip)
                .then(function(resp) {
                    app.feedsData = resp.data
                    app.loadFeed = false
                })
                .catch(function(resp) {
                    console.log(resp)
                    app.loadFeed = false
                    alert('Could not load feeds')
                })
        },
    },
    mounted() {
        const app = this
        axios
            .get('/api/v1/categories')
            .then(function(resp) {
                app.categories = resp.data.map(v => {
                    return {
                        value: v['id'],
                        text: v['title'],
                    }
                })
            })
            .catch(function(resp) {
                console.log(resp)
                alert('Could not load categories')
            })
        this.getFeeds()
    },
}
</script>
