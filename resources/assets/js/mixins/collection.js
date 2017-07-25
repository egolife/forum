export default {
    data() {
        return {
            items: [],
        };
    },
    methods: {
        add(item) {
            this.$emit('added');
            this.items.push(item);
        },
        remove(index) {
            this.$emit('removed');
            this.items.splice(index, 1);
        },
    },
};