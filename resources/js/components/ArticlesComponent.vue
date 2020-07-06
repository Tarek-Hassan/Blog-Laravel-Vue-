<template>
    <div>
        <h1 class="my-3 bg-warning">Posts</h1>
        <div class="mx-2 my-2">
            <form @submit.prevent="addPost()">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">BOdy</label>
                    <textarea class="form-control" v-model="post.body" id="exampleFormControlTextarea1" rows="3" placeholder="BOdy"></textarea>
                </div>
                <button v-if="is_edit" type="submit" class="btn btn-secondary">Update</button>
                <button v-else  type="submit" class="btn btn-success"> Save</button>
            </form>
        </div>
        <hr/>
        <div class="card text-white bg-secondary mx-2 my-2" v-for="post in posts" v-bind:key="post.id">
            <div class="card-header float-right">{{post.created_at}}</div>
            <div class="card-body">
                <p class="card-text">{{post.body}}</p>
            </div>
            <div class="card-header float-right">{{post.user.name}}</div>
            <div>
                <button @click="deletePost(post.id)" class="btn btn-danger"> delete</button>
                <button @click="fillform(post)" class="btn btn-info"> update</button>
            </div>
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li v-bind:class="[{disabled: !paginate.prev}]" class="page-item ">
                    <a @click="getPosts(paginate.prev)" class="page-link" tabindex="-1" href="">Previous</a>
                </li>
                <li class="page-item"><a class="page-link " disabled>page {{paginate.current_page}} of
                        {{paginate.last_page}} </a></li>

                <li v-bind:class="[{disabled: !paginate.next}]" class="page-item">
                    <a @click="getPosts(paginate.next)" href="" class="page-link">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        props:['user_id'],
        data() {
            return {
                posts: [],
                post: {
                    id: '',
                    body: '',
                    user_id: this.user_id,
                },
                paginate: {},
                is_edit: false,
            }
        },

        created() {
            this.getPosts();
        },

        methods: {
            getPosts(pageUrl) {
                let vm = this;
                pageUrl = pageUrl || '/api/posts'
                fetch(pageUrl)
                    .then(res => res.json())
                    .then(res => {
                        this.posts = res.data;
                        vm.makepaginate(res.links, res.meta);
                    })
                    .catch(err => console.log(err))

            },
            deletePost(id) {
                if (confirm('Are u s')) {

                    fetch(`/api/posts/${id}`, {
                            method: 'delete'
                        })
                        .then(res => res.json())
                        .then(res => this.getPosts())
                        .catch(err => console.log(err))
                }
            },
            makepaginate(link, meta) {
                let paginate = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    prev: link.prev,
                    next: link.next,
                }
                this.paginate = paginate;
            },

            fillform(post){
                this.post.id=post.id;
                this.post.body=post.body;
                this.is_edit=true;

                
            },
            addPost(){      
                console.log("******");
                console.log(this.post);
                console.log("******");          
                if(this.is_edit === false){
                    console.log("post");
                    console.log(this.post);
                    fetch(`/api/posts`, {
                            method: 'post',
                            body:JSON.stringify(this.post),
                            headers:{
                                'content-type':'application/json'
                            }   
                        })
                        .then(res => res.json())
                        .then(data =>{
                            this.post.id='';
                            this.post.body='';
                    this.getPosts();})
                        .catch(err => console.log(err))
                }else{
                    console.log("edit");
                    // this.user_id
                    console.log(this.post);
                    fetch(`/api/posts/${this.post.id}`, {
                            method: 'put'
                        ,body:JSON.stringify(this.post),
                        headers:{
                            'content-type':'application/json'
                        }   
                        })
                        .then(res => res.json())
                        .then(res => this.getPosts())
                        .catch(err => console.log(err))
                

                }
                

                // }

                }

        }
    }

</script>
