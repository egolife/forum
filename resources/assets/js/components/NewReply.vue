<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <label for="body">Body:</label>
                <textarea name="body"
                          id="body"
                          rows="4"
                          class="form-control"
                          placeholder="Have smth to say?"
                          required
                          v-model="body"
                ></textarea>
            </div>
            <button class="btn btn-default" @click="addReply">Post</button>
        </div>


        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to participate in this discussion
        </p>
    </div>
</template>

<script>
    export default {
        props: ['endpoint'],
        data() {
            return {
                body: '',
            };
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            },
        },
        methods: {
            addReply() {
                axios.post(this.endpoint, {body: this.body})
                    .then(response => {
                        this.body = '';

                        flash('Your reply has been posted!');

                        this.$emit('created', response.data);
                    });
            },
        },
    };
</script>