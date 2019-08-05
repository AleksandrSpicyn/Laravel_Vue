<template>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-two-fifths">
                    <aside class="menu">
                        <p class="menu-label">
                            Categories
                        </p>
                        <ul class="menu-list">
                            <tree
                                    @getProducts='getProducts'
                                    @setActive='setActive'
                                    v-for="model in categories"
                                    v-if="categories"
                                    class="item"
                                    :model="model"
                                    :active="active"
                            >
                            </tree>
                        </ul>
                    </aside>
                </div>
                <div class="column">
                    <p>Products</p>
                    <table class="table is-fullwidth">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="products" v-for="product in products">
                            <td>{{product.name}}</td>
                            <td>{{product.description}}</td>
                            <td><a target="_blank" v-bind:href="product.img">Open image</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import axios from 'axios';
    import r from '../route';
    import tree from './Tree'

    export default {
        name: "Products",
        components: {'tree': tree},
        data() {
            return {
                categories: [],
                products: [],
                active: 0
            }
        },
        computed: {
            cCategories: function () {
                return this.categories
            }
        },
        methods: {
            getCategories() {
                axios.get(r("categories.index") + '?hierarchy=1')
                    .then((response) => {
                        this.categories = response.data;
                    });
            },
            getProducts(id) {
                axios.get(r("categories.index") + '/' + id)
                    .then((response) => {
                        this.products = response.data.products
                    });
            },
            setActive(id) {
                this.active = id
            }
        },
        mounted: function () {
            this.categories = this.getCategories();
        },
        watch: {
            categories(newValue) {
                if (typeof newValue != "undefined") {
                    this.products = this.getProducts(newValue[0].id)
                }
            }
        }
    }
</script>