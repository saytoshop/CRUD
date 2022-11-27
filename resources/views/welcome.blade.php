<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width">
    <meta http-equiv=" X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container" id="app">
    <div class="row">
        <div class="col-sm-12 mb-4">
            <a href="#" class="btn btn-outline-dark" @click.prevent="getProducts(null)"
               title="получение списка товаров">GET /products</a>
            <a href="#" class="btn btn-outline-dark" @click.prevent="getCategories" title="получение категорий">GET
                /categories</a>
            <a href="#" class="btn btn-outline-dark" @click.prevent="getCategories(1)"
               title="получение списка категорий c вложенными товарами">GET
                /categories?includeProducts=1</a>
            <form action="" class=" mt-2 shadow-sm" v-if="action == 'editProduct'">
                <div class="form-group row">
                    <div class="col">
                        <input type="text" class="form-control" v-model="productName" placeholder="product name">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="productPrice" placeholder="product price">
                    </div>
                    <div class="col">
                        <select class="form-control" v-model="productCategory">
                            <option value="0">no category</option>
                            <option :value="category.id" v-for="category in categories">@{{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-outline-dark" @click.prevent="updateProduct">POST /products</a>
                    </div>
                </div>
            </form>
            <form action="" class=" mt-2 shadow container p-4 rounded" v-if="action == 'deleteProduct'">
                <div class="mb-2">
                    <p>удаление продукта</p>
                    <select class="form-control col-md-4" v-model="productToEdit">
                        <option :value="product.id" v-for="product in products">@{{ product.name }}</option>
                    </select>
                </div>
                <div class="col">
                    <a href="#" class="btn btn-outline-dark" @click.prevent="deleteProduct">DELETE
                        /products/{id}</a>
                </div>
            </form>
            <form action="" class=" mt-2  shadow container p-4 rounded" v-if="action == 'addProduct'">
                <div class="form-group row">
                    <div class="col">
                        <input type="text" class="form-control" v-model="productName" placeholder="product name">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" v-model="productPrice" placeholder="product price">
                    </div>
                    <div class="col">
                        <select class="form-control" v-model="productCategory">
                            <option value="0">no category</option>
                            <option :value="category.id" v-for="category in categories">@{{ category.name }}</option>
                        </select>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-outline-dark" @click.prevent="createProduct">POST /products</a>
                    </div>
                </div>
            </form>

            <form action="" class=" mt-2 shadow container p-4 rounded" v-if="action == 'addCategory'">
                <div class="form-group row">
                    <div class="col">
                        <input type="text" class="form-control" v-model="categoryName" placeholder="category name">
                    </div>
                    <div class="col">
                        <select class="form-control" v-model="categoryParent">
                            <option value="0">no parent</option>
                            <option :value="category.id" v-for="category in categories">@{{ category.name }}</option>
                        </select>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-outline-dark"
                           @click.prevent="createCategory">POST /categories</a>
                    </div>
                </div>
            </form>
            <form action="" class=" mt-2 shadow container p-4 rounded" v-if="action == 'editCategory'">

                <p>Новые значения:</p>
                <div class="form-group row">
                    <div class="col">
                        <input type="text" class="form-control" v-model="categoryName" placeholder="category name">
                    </div>
                    <div class="col">
                        <select class="form-control" v-model="categoryParent">
                            <option value="0">no parent</option>
                            <option :value="category.id" v-for="category in categories">@{{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-outline-dark"
                           @click.prevent="updateCategory">POST /categories</a>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-md-8">
            <h3 class="d-flex justify-content-between">Categories <a href="#" class="btn btn-outline-primary btn-sm"
                                                                     @click.prevent="action='addCategory'">Add</a>
            </h3>
            <ul class="list-group list-group-flush">
                <li v-for="category in categories"
                    class="list-group-item d-flex justify-content-between align-items-baseline">
                    <div>
                        <a href="#">@{{ category.name }}</a>
                        <ul v-if="category.products">
                            <li v-for="product in category.products">
                                @{{ product.name }}
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="#" class="btn btn-outline-primary btn-sm mb-1"
                           @click.prevent="action='editCategory'; categoryToEdit=category.id">Edit</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm mb-1"
                           @click.prevent="getCategory(category.id)"
                           title="получение одной категории c вложенными товарами">GET
                            /categories/{id}?includeProducts=1</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm mb-1"
                           @click.prevent="getProducts(category.id)" title="получение списка товаров из категории">GET
                            /categories/{id}/products</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm mb-1"
                           @click.prevent="getProducts(category.id, 1)"
                           title=" получение списка товаров из категории и всех вложенных в неё категорий одним списком">GET
                            /categories/{id}/products?includeChildren=1</a>


                    </div>


                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <h3 class="d-flex justify-content-between">Products <a href="#" class="btn btn-outline-primary btn-sm"
                                                                   @click.prevent="action='addProduct'">Add</a></h3>

            <ul class="list-group list-group-flush">
                <li v-for="product in products" class="list-group-item d-flex justify-content-between">
                    <p>@{{ product.name }}</p>
                    <div>
                        <a href="#" class="btn btn-outline-primary btn-sm"
                           @click.prevent="action='editProduct'; productToEdit=product.id">Edit</a>
                        <a href="#" class="btn btn-outline-danger btn-sm"
                           @click.prevent="action='deleteProduct'; productToEdit=product.id">Delete</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    const app = new Vue({
        el: "#app",
        data: {
            productName: '',
            productPrice: '',
            productCategory: 0,
            categoryName: '',
            categoryParent: '',
            productToEdit: 0,
            categoryToEdit: 0,
            action: '',
            categories: [],
            products: []
        },
        methods: {
            resetTempValues() {
                this.productName = ''
                this.productPrice = ''
                this.productCategory = 0
                this.categoryName = ''
                this.categoryParent = ''
                this.productToEdit = 0
                this.categoryToEdit = 0
                this.action = ''
            },
            createProduct() {
                axios.post('/api/products', {
                    name: this.productName,
                    price: this.productPrice,
                    category_id: this.productCategory
                }).then(response => this.resetTempValues())
                    .catch(function (error) {
                        // handle error
                        alert(error.response.data.message);
                    })
            },
            deleteProduct() {
                axios.delete(`/api/products/${this.productToEdit}`).then(response => this.resetTempValues())
            },
            updateProduct() {
                axios.post(`/api/products/${this.productToEdit}`, {
                    name: this.productName,
                    price: this.productPrice,
                    category_id: this.productCategory
                }).then(response => this.resetTempValues())
                    .catch(function (error) {
                        // handle error
                        alert(error.response.data.message);
                    })
            },
            createCategory() {
                axios.post('/api/categories', {
                    name: this.categoryName,
                    parent_id: this.categoryParent
                }).then(response => this.resetTempValues())
                    .catch(function (error) {
                        // handle error
                        alert(error.response.data.message);
                    })
            },
            updateCategory() {
                axios.post(`/api/categories/${this.categoryToEdit}`, {
                    name: this.categoryName,
                    parent_id: this.categoryParent,

                }).then(response => this.resetTempValues())
            },
            getCategories(includeProducts = 0) {
                axios.get('/api/categories', {
                    params: {
                        includeProducts: includeProducts
                    }
                }).then(
                    (response) => this.categories = response.data
                )
                    .catch(function (error) {
                        // handle error
                        alert(error.response.data.message);
                    })
            },
            getCategory(id) {
                axios.get(`/api/categories/${id}`, {
                    params: {
                        includeProducts: 1
                    }
                }).then(
                    (response) => this.categories = [response.data]
                ).catch(function (error) {
                    // handle error
                    alert(error.response.data.message);
                })
            },
            getProducts(category = null, includeChildren = 0) {
                let url = category ? `/api/categories/${category}/products` : '/api/products'
                axios.get(url, {
                    params: {
                        includeChildren: includeChildren
                    }
                }).then(
                    (response) => this.products = response.data
                )
                    .catch(function (error) {
                        // handle error
                        alert(error.response.data.message);
                    })
            }
        },
        created() {
            this.resetTempValues()
            this.getCategories()
            this.getProducts()
        }
    })
</script>
</body>
</html>
