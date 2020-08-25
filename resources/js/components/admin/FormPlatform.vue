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
        </form>

        <div class="col-sm mt-3" id="platform-sub-btn">
            <button class="btn btn-block btn-success" @click="savePlatform">SUBMIT PLATFORM</button>
        </div>

        <table class="table mt-4">
            <thead>
            <tr>
                <th scope="col" class="borderless text-center">ID</th>
                <th scope="col" class="borderless text-center">Name</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="platform in platforms" :key="platform.id">
                <th class="text-center" v-text="platform.id"></th>
                <td class="text-center" v-text="platform.name"></td>
                <td class="text-right">
                    <button class="btn btn-sm btn-primary" @click="editPlatform(platform)">Edit</button>
                    <button class="btn btn-sm btn-danger" @click="deletePlatform(platform)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="row justify-content-center" id="platform-page-btn">
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
    data: function() {
        return {
            platform_api: apiJson[0]['platform_api'],
            id: '',
            name: '',
            platforms: [],
            current_page: 1,
            last_page: '',
            loading: true,
            alert: '',
        }
    },

    components: {
        'form-popup' : FormPopups
    },

    mounted() {
        this.loadPlatforms();
        this.test();
    },

    methods: {
        loadPlatforms: function () {
            this.platforms = [];
            axios({
                method: "get",
                url: this.platform_api + "/paginate?page=" + this.current_page
            })
                .then( response => {
                    for(let i = 0; i < response.data['data'].length; i++)
                        this.platforms.push(response.data['data'][i]);

                    this.current_page = response.data['meta']['current_page'];
                    this.last_page = response.data['meta']['last_page'];
                    this.pageLoading();
                }).catch(error => {
                    FormPopups.methods.showDangerAlert(this.alert = error);
                }
            );
        },

        savePlatform: function () {
            let formData = new FormData();
            formData.append("name", this.name);

            if(this.id){
                formData.append("_method", "PUT");

                axios({
                    url: this.platform_api + "/" + this.id,
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
                    url: this.platform_api,
                    data: formData,
                    method: 'POST',
                }).then(response => {
                    this.name = '';

                    this.loadPlatforms();
                    FormPopups.methods.showSuccessAlert(this.alert = "Platform has been saved!");
                }).catch(error => {
                    console.log(error)
                        FormPopups.methods.showDangerAlert(this.alert = error);
                    }
                );
            }
        },

        deletePlatform: function (platform) {
            axios({
                method: "delete",
                url: this.platform_api + "/" + platform.id
            })
                .then( response => {
                    this.loadPlatforms();
                    FormPopups.methods.showDangerAlert(this.alert = "Platform has been deleted!");
                }).
            catch( error => {
                FormPopups.methods.showDangerAlert(this.alert = error);
            });
        },

        editPlatform: function (user) {
            this.id = user.id;
            this.name = user.name;
        },

        incCurrentPage: function () {
            this.current_page++;
            this.loadPlatforms();
        },

        decCurrentPage: function () {
            this.current_page--;
            this.loadPlatforms();
        },

        pageLoading: function () {
            this.loading = false;
            document.getElementById("platform-sub-btn").style.display = "unset";
            document.getElementById("platform-page-btn").style.display = "flex";
        },
    },
}
</script>
