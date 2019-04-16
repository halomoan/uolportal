<template>
    <div>
        <div v-if="selected">
            <img :src="selected.photo" alt="Photo" />
            <ul>
                <li>Name: {{ selected.name }}</li>
                <li>Email: {{ selected.email }}</li>
            </ul>
        </div>
        <cool-select
                v-model="selected"
                :items="items"
                :loading="loading"
                item-text="name"
                placeholder="Enter user's name"
                disable-filtering-by-search
                @search="onSearch"
        >
            <template slot="no-data">
                {{
                noData
                ? "No information found by request."
                : "We need at least 2 letters to search."
                }}
            </template>
            <template slot="item" slot-scope="{ item }">
                <div class="item">
                    <img :src="item.photo" class="photo" />

                    <div>
                        <span class="item-name"> {{ item.name }} </span> <br />
                        <span class="item-email"> {{ item.email }} </span>
                    </div>
                </div>
            </template>
        </cool-select>
    </div>
</template>

<script>
    import { CoolSelect } from "vue-cool-select";

    Vue.use(CoolSelect, {
        theme: 'material-design' // or 'material-design'
    })
    export default {
        components: {
            CoolSelect
        },
        data: () => ({
        selected: null,
        items: [],
        loading: false,
        timeoutId: null,
        noData: false
    }),
    methods: {
        async onSearch(search) {
            const lettersLimit = 2;

            this.noData = false;
            if (search.length < lettersLimit) {
                this.items = [];
                this.loading = false;
                return;
            }
            this.loading = true;

            clearTimeout(this.timeoutId);
            this.timeoutId = setTimeout(async () => {
                    const response = await fetch(
                            `/api/requester?query=${search}`
                    );

            this.items = await response.json();
            this.loading = false;

            if (!this.items.length) this.noData = true;

            console.log(this.items);
        }, 500);
        }
    }
    };
</script>

<style>
    .item {
        display: flex;
        align-items: center;
    }

    .item-name {
        font-size: 25px;
    }
    .item-email {
        color: grey;
    }

    .photo {
        max-width: 60px;
        margin-right: 10px;
        border: 1px solid #eaecf0;
    }
</style>