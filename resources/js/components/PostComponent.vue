<template>
    <div>
        <div class="card-header"><h3>Posts</h3></div>
        <div class="card card-body mb-2" v-for="article in posts" :key="article.id">
            <h4>{{ article.title }}</h4>
            <p>{{ article.content }}</p>
            <div>
                <h5 class="float-left">{{ article.author }}</h5>
                <div class="float-right">
                    <button class="btn btn-primary" @click="post = article">Edit</button>
                    <button class="btn btn-danger" @click="deletePost(article.id)">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <pagination ref="child" :fetchList="fetchPosts" :pagination="pagination" @makePagination="pagination = $event"></pagination>
</template>

<script>
    export default {
        name: "PostComponent",
        data(){
            return {
                posts: [''],
                post: {
                    id: '',
                    title: '',
                    content: '',
                    author: '',
                },
                pagination: {},
            };
        },
        created() {
            this.fetchPosts();
        },
        methods: {
            fetchPosts: function (page_url) {
                page_url = page_url || 'api/posts';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.posts = res.data;
                        this.$refs.child.makePagination(res.meta, res.links);
                    });
            },
            deletePost(id) {
                if (confirm('Are you sure?')) {
                    let vm = this;
                    fetch(`api/posts/${id}`, {
                        method: 'delete'
                    }).then(fun => {
                        let url =
                            this.pagination.path +
                            '?page=' +
                            this.pagination.current_page;
                        this.fetchPosts(url);
                    });
                }
            }
        }
    };
</script>

<style scoped>

</style>