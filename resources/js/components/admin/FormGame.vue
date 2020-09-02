<template>
    <div :class="{'loading': loading}" class="mt-6">
        <div class="text-center">
            <h2>Games</h2>
        </div>

        <form>
            <div class="form-group">
                <label for="name"><strong>Name:</strong></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Xbox" required v-model="name">
            </div>

            <div class="form-group">
                <label for="price"><strong>Price:</strong></label>
                <input type="text" id="price" name="price" class="form-control" placeholder="33.33" required v-model="price">
            </div>
        </form>

        <div class="col-sm mt-3" id="game-sub-btn">
            <button class="btn btn-block btn-success" @click="saveGame">SUBMIT GAME</button>
        </div>

        <table class="table mt-4">
            <thead>
            <tr>
                <th scope="col" class="borderless text-center">ID</th>
                <th scope="col" class="borderless text-center">Name</th>
                <th scope="col" class="borderless text-center">Price</th>
                <th scope="col" class="borderless text-center">Category</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="game in games" :key="game.id">
                <th class="text-center" v-text="game.id"></th>
                <td class="text-center" v-text="game.name"></td>
                <td class="text-center" v-text="game.price"></td>
                <td class="text-center">
                    <div class="categories-in-game" :id="'game_' + game.id">
                        <div v-for="category in game.category" :key="category.id" class="category-in-game">
                            <p v-text="category.name"></p>
                            <button class="btn btn-sm btn-danger" @click="deleteGameCategory(game, category)">x</button>
                        </div>
                    </div>
                    <div class="add-category">
                        <button class="btn btn-sm btn-success" @click="addCategoryFields(game)">+</button>
                    </div>
                </td>
                <td class="text-right">
                    <button class="btn btn-sm btn-primary" @click="editGame(game)">Edit</button>
                    <button class="btn btn-sm btn-danger" @click="deleteGame(game)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <select id="category-option" v-model="category" class="form-control form-control-sm">
            <option v-for="category in categories" :key="category.id" v-bind:value="category.id" v-text="category.name"></option>
        </select>

        <div class="row justify-content-center" id="game-page-btn">
            <div class="col-sm-6 text-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" v-if="current_page !== 1" @click="decCurrentPage">Previous</button>
                    <button class="btn btn-outline-secondary" v-text="current_page"></button>
                    <button type="button" class="btn btn-secondary" v-if="current_page !== last_page" @click="incCurrentPage">Next</button>
                </div>
            </div>
        </div>
        <hr>
    </div>
</template>

<script>

import axios from "axios"
import apiJson from "../../config/config.json"

export default {
    data: function() {
        return {
            game_api: apiJson[0]['game_api'],
            categoryInGame_api: apiJson[0]['categoryInGame_api'],
            category_api: apiJson[0]['category_api'],
            id: '',
            name: '',
            price: '',
            games: [],
            categories: [],
            category: '',
            current_page: 1,
            last_page: '',
            loading: true,
        }
    },

    mounted() {
        this.loadGames();
        this.loadCategories();
    },

    methods: {
        loadGames: function () {
            this.games = [];
            axios({
                method: "get",
                url: this.game_api + "/paginate?page=" + this.current_page
            })
                .then( response => {
                    for(let i = 0; i < response.data['data'].length; i++)
                        this.games.push(response.data['data'][i]);

                    this.current_page = response.data['meta']['current_page'];
                    this.last_page = response.data['meta']['last_page'];
                    this.pageLoading();
                }).catch(error => {
                    // FormPopups.methods.showDangerAlert(this.alert = error);
                }
            );
        },

        loadCategories: function () {
            this.categories = [];

            axios({
                method: "get",
                url: this.category_api
            })
                .then( response => {
                    for(let i = 0; i < response.data['data'].length; i++)
                        this.categories.push(response.data['data'][i]);

                }).
            catch( error => {
                console.log(error);
            });
        },

        saveGame: function () {
            let formData = new FormData();
            formData.append("name", this.name);
            formData.append("price", this.price);

            if(this.id){
                formData.append("_method", "PUT");

                axios({
                    url: this.game_api + "/" + this.id,
                    data: formData,
                    method: 'POST',
                }).then(response => {
                    this.name = '';
                    this.price = '';

                    this.loadGames();
                    // FormPopups.methods.showSuccessAlert(this.alert = "Platform has been edited!");
                }).catch(error => {
                        // FormPopups.methods.showDangerAlert(this.alert = error);
                    }
                );
            }else {
                axios({
                    url: this.game_api,
                    data: formData,
                    method: 'POST',
                }).then(response => {
                    this.name = '';

                    this.loadGames();
                    // FormPopups.methods.showSuccessAlert(this.alert = "Platform has been saved!");
                }).catch(error => {
                        console.log(error)
                        // FormPopups.methods.showDangerAlert(this.alert = error);
                    }
                );
            }
        },

        deleteGame: function (game) {
            axios({
                method: "delete",
                url: this.game_api + "/" + game.id
            })
                .then( response => {
                    this.loadGames();
                    // FormPopups.methods.showDangerAlert(this.alert = "Platform has been deleted!");
                }).
            catch( error => {
                // FormPopups.methods.showDangerAlert(this.alert = error);
            });
        },

        deleteGameCategory: function (game, category){
            axios({
                method: "delete",
                url: this.categoryInGame_api + "/game/" + game.id + "/category/" + category.id
            })
                .then( response => {
                    this.loadGames();
                    // FormPopups.methods.showDangerAlert(this.alert = "Platform has been deleted!");
                }).
            catch( error => {
                // FormPopups.methods.showDangerAlert(this.alert = error);
            });
        },

        editGame: function (game) {
            this.id = game.id;
            this.name = game.name;
            this.price = game.price;
        },

        addCategoryFields: function (game){
            let tag = document.createElement("div");
            tag.setAttribute("id", "category")

            let itm = document.getElementById("category-option");
            let cln = itm.cloneNode(true);

            let button = document.createElement("button");
            button.innerText = "✔";
            button.setAttribute("class", "btn btn-sm btn-secondary")

            tag.appendChild(button);
            tag.appendChild(cln);

            let element = document.getElementById("game_" + game.id);
            element.appendChild(tag);
        },

        incCurrentPage: function () {
            this.current_page++;
            this.loadGames();
        },

        decCurrentPage: function () {
            this.current_page--;
            this.loadGames();
        },

        pageLoading: function () {
            this.loading = false;
            document.getElementById("game-sub-btn").style.display = "unset";
            document.getElementById("game-page-btn").style.display = "flex";
        },
    },
}
</script>
