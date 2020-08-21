<template>
    <div :class="{'loading': loading}">
        <form>
            <div class="form-group">
                <label for="name"><strong>Name:</strong></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Multiplayer games" required v-model="name">
            </div>

            <div class="form-group" id="country">
                <strong>Platform:</strong>
                <select v-model="platform" class="form-control">
                    <option v-for="platform in platforms" :key="platform.id" v-bind:value="platform.id" v-text="platform.name"></option>
                </select>
            </div>
        </form>

        <div class="col-sm mt-3" id="category-sub-btn">
            <button class="btn btn-block btn-success" @click="saveCategory">SUBMIT CATEGORY</button>
        </div>

        <table class="table mt-4">
            <thead>
            <tr>
                <th scope="col" class="borderless text-center">ID</th>
                <th scope="col" class="borderless text-center">Name</th>
                <th scope="col" class="borderless text-center">Platform</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="category in categories" :key="category.id">
                <th class="text-center" v-text="category.id"></th>
                <td class="text-center" v-text="category.name"></td>
                <td class="text-center" v-text="category.platform.name"></td>
                <td class="text-right">
                    <button class="btn btn-sm btn-primary" >Edit</button>
                    <button class="btn btn-sm btn-danger" >Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="row justify-content-center" id="category-page-btn">
            <div class="col-sm-6 text-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" v-if="current_page !== 1" @click="decCurrentPage">Previous</button>
                    <button class="btn btn-outline-secondary" v-text="current_page"></button>
                    <button type="button" class="btn btn-secondary" v-if="current_page !== last_page" @click="incCurrentPage">Next</button>
                </div>
            </div>
        </div>
        <hr>

        <form-popup :alert="alert"></form-popup>
    </div>
</template>
<script>

import axios from "axios"
import apiJson from "../../config/config.json"
import FormPopups from "./FormPopups";

export default {
    data: function () {
        return {
            category_api: apiJson[0]['category_api'],
            platform_api: apiJson[0]['platform_api'],
            platform: '',
            platforms: [],
            name: '',
            id: '',
            categories: [],
            current_page: 1,
            last_page: '',
            loading: true,
            alert: ''
        }
    },

    components: {
        'form-popup' : FormPopups
    },

    mounted() {
        this.loadCategories();
        this.loadPlatforms();
    },

    methods: {
        loadCategories: function () {
            this.categories = [];

            axios({
                method: "get",
                url: this.category_api + "/paginate?page=" + this.current_page
            })
                .then( response => {
                    for(let i = 0; i < response.data['data'].length; i++)
                        this.categories.push(response.data['data'][i]);

                    this.current_page = response.data['meta']['current_page'];
                    this.last_page = response.data['meta']['last_page'];
                    this.pageLoading();
                }).
            catch( error => {
                console.log(error);
            });
        },

        loadPlatforms: function () {
            this.platforms = [];
            axios({
                method: "get",
                url: this.platform_api
            })
                .then( response => {
                    for(let i = 0; i < response.data['data'].length; i++)
                        this.platforms.push(response.data['data'][i]);
                }).catch(error => {
                    FormPopups.methods.showDangerAlert(this.alert = error);
                }
            );
        },

        saveCategory: function () {
            let formData = new FormData();
            formData.append("name", this.name);
            formData.append("platform_id", this.platform);

            if(this.id){
                formData.append("_method", "PUT");

                axios({
                    url: this.category_api + "/" + this.id,
                    data: formData,
                    method: 'POST',
                }).then(response => {
                    this.name = '';

                    this.loadPlatforms();
                    FormPopups.methods.showSuccessAlert(this.alert = "Platform has been edited!");
                }).catch(error => {
                        FormPopups.methods.showDangerAlert(this.alert = error);
                    }
                );
            }else {
                axios({
                    url: this.category_api,
                    data: formData,
                    method: 'POST',
                }).then(response => {
                    this.name = '';
                    this.platform = '';

                    this.loadCategories();
                    FormPopups.methods.showSuccessAlert(this.alert = "Platform has been saved!");
                }).catch(error => {
                        console.log(error)
                        FormPopups.methods.showDangerAlert(this.alert = error);
                    }
                );
            }
        },

        incCurrentPage: function () {
            this.current_page++;
            this.loadCategories()
        },

        decCurrentPage: function () {
            this.current_page--;
            this.loadCategories();
        },

        pageLoading: function () {
            this.loading = false;
            document.getElementById("category-sub-btn").style.display = "unset";
            document.getElementById("category-page-btn").style.display = "flex";
        },
    },

}
</script>
