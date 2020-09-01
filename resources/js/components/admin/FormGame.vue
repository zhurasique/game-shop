<template>
    <div :class="{'loading': loading}">
        <div class="text-center">
            <h2>Platforms</h2>
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
                <td class="text-center" v-text="game.category[0]"></td>
                <td class="text-right">
                    <button class="btn btn-sm btn-primary" @click="editGame(game)">Edit</button>
                    <button class="btn btn-sm btn-danger" @click="deleteGame(game)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

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
            id: '',
            name: '',
            price: '',
            games: [],
            current_page: 1,
            last_page: '',
            loading: true,
        }
    },

    mounted() {
        this.loadGames();
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

                    this.loadPlatforms();
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

                    this.loadPlatforms();
                    // FormPopups.methods.showSuccessAlert(this.alert = "Platform has been saved!");
                }).catch(error => {
                        console.log(error)
                        // FormPopups.methods.showDangerAlert(this.alert = error);
                    }
                );
            }
        },

        deleteGame: function (platform) {
            axios({
                method: "delete",
                url: this.game_api + "/" + platform.id
            })
                .then( response => {
                    this.loadPlatforms();
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
