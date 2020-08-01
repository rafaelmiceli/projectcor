<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <span>Alphabet Soups</span>
                        <b-button @click="generate_matrix" class="float-right" variant="success">Agregar Matriz</b-button>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6 mb-2" v-if="matrix.length>0">
                            <b-form inline>
                                <b-form-select
                                id="inline-form-custom-select-pref"
                                class="mb-2 mr-sm-2 mb-sm-0"
                                :options="options"
                                :value="null"
                                v-model="midx"
                                ></b-form-select>
                                <b-button  type="button" @click="check()" variant="primary" class="mr-4">Check for "OIE"</b-button>
                                {{output}}
                            </b-form>
                        </div>
                        <matrix-component :matrix="m" :num="idx + 1" v-for="(m,idx) in matrix" :key="idx"></matrix-component>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            count: 0,
            matrix: [],
            cols: 0,
            rows: 0,
            max_cols: 11,
            max_rows: 8,
            output: '',
            midx: null,
            options: [{
                text: 'Select a Matrix ',
                value: null
            }]
        };
    },
    mounted() {
        
        console.log('Component mounted.')
    },
    methods: {
        generate_matrix() {
            let rows = []
            let index = this.matrix.length
            for (let i = 1; i < (this.max_rows+1); i++) {
                let cols = []
                for (let j = 1; j < (this.max_cols+1); j++) {
                    cols.push(this.generate_random_vocals());
                }
                rows.push(cols);
                cols.slice()
            }
            this.matrix.push(rows);
            this.options.push({
                text: 'Matrix ' + this.matrix.length,
                value: index
            })
        },
        async check() {
            if(this.midx==null) {
                return false;
            }
            try {
                const response = await axios.post("/check", {
                        data: this.matrix[this.midx]
                    }, {
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json"
                    }
                }).then(response => {
                    this.output = `OIE Pattern count: ${response.data.count} `;
                });
            } catch (error) {
                console.log(error);
            }
        },
        generate_random_vocals() {
            let min = 0
            let max
            let aux = [79,73,69,85,65] //force vocals filling

                max = aux.length
            let random = Math.floor(Math.random() * (max - min) ) + min;
            return String.fromCharCode(aux[random]);
        },
        generate_random(min=65, max=90) {
            let random = Math.floor(Math.random() * (max - min) ) + min;
            return String.fromCharCode(random);
        }
    }
}
</script>