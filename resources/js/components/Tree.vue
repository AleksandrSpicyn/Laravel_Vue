<template>
    <li>
        <div>
            <a :class="{ 'is-active': active === model.id }" @click="getProducts(model.id)">{{model.name}}
                <span v-if="isFolder" @click="toggle">[{{open ? '-' : '+'}}]</span>
            </a>
        </div>
        <ul v-show="open" v-if="isFolder" class="menu-list">
            <tree
                    @getProducts='getProducts'
                    class="item"
                    v-for="model in model.children"
                    :model="model"
                    :active="active"
            >
            </tree>
        </ul>
    </li>
</template>
<script>
    export default {
        name: 'tree',
        props: {
            model: Object,
            active: 0,
        },
        data() {
            return {
                open: true,
                products: []
            }
        },
        computed: {
            isFolder: function () {
                return this.model.children &&
                    this.model.children.length
            }
        },
        methods: {
            toggle: function () {
                if (this.isFolder) {
                    this.open = !this.open
                }
            },
            getProducts(id) {
                this.$emit('getProducts', id);
                this.$emit('setActive', id);
            },
            getLog(message) {
                console.log(message)
            }
        },
    }
</script>