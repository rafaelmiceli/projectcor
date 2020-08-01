<template>
    <div>
        <b-form-input v-model="letter" class="letter" readonly></b-form-input>
    </div>
</template>

<script>
    export default {
        props: ['letter'],
        data() {
            return {
            };
        }
    }
</script>

<style lang="css" scoped>
/deep/ .letter {
	color: white;
    font-weight: bold;
	background-color: black;
    text-align: center;
    width: 50px;
}
</style>
