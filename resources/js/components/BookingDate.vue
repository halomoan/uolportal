<template>

    <datepicker v-model="date" input-class="input form-control" name="fordate" format="D, d MMM, yyyy"></datepicker>

</template>

<script>

    import Datepicker from 'vuejs-datepicker';

    export default {
        components: {
            Datepicker
        },
        data() {
            return {
                date: new Date()
            }
        }
    }
</script>