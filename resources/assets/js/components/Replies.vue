<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from '../components/NewReply.vue';

    export default {
        props: ['data'],
        components: {Reply, NewReply},
        data() {
            return {
                items: this.data,
                endpoint: location.pathname + '/replies',
            };
        },
        methods: {
            remove(index) {
                this.$emit('removed');
                this.items.splice(index, 1);
                flash('Reply was deleted!');
            },
            add(reply) {
                this.$emit('added');
                this.items.push(reply);
            },
        },
    };
</script>