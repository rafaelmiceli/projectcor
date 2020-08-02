<template>
    <div class="float-left mb-2 mr-2">
        <div class="card">
            <h5 class="card-header">Matrix {{index+1}}</h5>
            <div class="card-body" style="min-height:300px !important">
                <b-row v-for="(a1, i1) in matrix" :key="i1">
                    <b-col cols="1" v-for="(a2, i2) in a1" :key="i2">
                        <cell-component :letter="a3" v-for="(a3, i3) in a2" :key="i3"></cell-component>
                    </b-col>
                </b-row>
            </div>
            <div class="card-footer">
                <b-button @click="removeMatrix(index)" class="float-right" variant="danger">Remove</b-button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ['index','matrix'],
    data() {
        return {
        };
    },
    methods: {
        removeMatrix(index) {
            this.$emit('remove-matrix', index)
        }
    }
}
</script>

<style lang="css" scoped>
/deep/ .col-1 {
    padding: 0 !important;
    max-width:none;
}
/deep/ .card-matrix {
    min-height:500px !important;
}
</style>