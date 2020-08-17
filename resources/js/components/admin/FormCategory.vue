<template>
    <div :class="{'loading': loading}">
        <form>
            <div class="form-group">
                <label for="name"><strong>Name:</strong></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Multiplayer games" required v-model="name">
            </div>

            <div class="form-group" id="country">
                <strong>Country:</strong>
                <select v-model="platform" class="form-control">
                    <option v-for="platform in platforms" :key="platform.id" v-bind:value="platform" v-text="platform.name"></option>
                </select>
            </div>
        </form>

        <div class="col-sm mt-5" id="subBtn">
            <button class="btn btn-block btn-success">SUBMIT USER</button>
        </div>

        <table class="table mt-4">
            <thead>
            <tr>
                <th scope="col" class="borderless">ID</th>
                <th scope="col" class="borderless">Name</th>
                <th scope="col" class="borderless">Platform</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="category in categories" :key="category.id">
                <th v-text="category.id"></th>
                <th v-text="category.name"></th>
                <td v-text="category.platform.name"></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary" >Edit</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="row justify-content-center" id="pageBtn">
            <div class="col-sm-6 text-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" v-if="current_page !== 1" @click="decCurrentPage">Previous</button>
                    <button class="btn btn-outline-secondary" v-text="current_page"></button>
                    <button type="button" class="btn btn-secondary" v-if="current_page !== last_page" @click="incCurrentPage">Next</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import axios from "axios"
import apiJson from "../../config/config.json"
import FormPopups from "./FormPopups";

export default {
    data: function (){
        return {
            category_api: apiJson[0]['category_api'],
            platform: '',
            platforms: [],
            name: '',
            id: '',
            categories: [],
            current_page: 1,
            last_page: '',
            loading: true
        }
    },

    mounted(){
        this.loadCategories();
    },

    methods: {
        loadCategories: function () {
            this.categories = [];

            axios({
                method: "get",
                url: this.category_api + "/paginate?page=" + this.current_page
            })
                .then( response => {
                    for(var i = 0; i < response.data['data'].length; i++){
                        this.categories.push(response.data['data'][i]);
                    }

                    this.current_page = response.data['meta']['current_page'];
                    this.last_page = response.data['meta']['last_page'];
                    this.pageLoading();
                }).
            catch( error => {
                console.log(error);
            });
        },

        incCurrentPage: function (){
            this.current_page++;
            this.loadCategories()
        },

        decCurrentPage: function (){
            this.current_page--;
            this.loadCategories();
        },

        pageLoading: function (){
            this.loading = false;
            document.getElementById("subBtn").style.display = "unset";
            document.getElementById("pageBtn").style.display = "flex";
        },
    },

}
</script>
