<template>
    <div class="float-left col-md-6  mb-2">
        <div class="card">
            <h5 class="card-header">Matrix {{num}}</h5>
            <div class="card-body">
                <b-row v-for="(a1, i1) in matrix" :key="i1">
                    <b-col cols="1" v-for="(a2, i2) in a1" :key="i2">
                        <cell-component :letter="a3" v-for="(a3, i3) in a2" :key="i3"></cell-component>
                    </b-col>
                </b-row>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ['num','matrix'],
    data() {
        return {

        };
    },
    computed: {
        get_header() {
            this.header = "Matriz " + this.num
        }
    },
    methods: {
        
    }
}
</script>

<style lang="css" scoped>
/deep/ .col-1 {
    padding: 0 !important;
    max-width:none;
}
</style>