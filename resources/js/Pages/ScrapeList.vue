<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-dt';
import DangerButton from "@/Components/DangerButton.vue";
DataTable.use(DataTablesCore);

const props = defineProps({
    articles: {
        type: Array,
        required: true,
    },
});

const dtColumns = [
    {
        data: 'id',
        title: 'ID',
    },
    {
        data: 'title',
        title: 'Title',
    },
    {
        data: 'source',
        title: 'Source',
    },
    {
        data: 'score',
        title: 'Score',
    },
    {
        data: 'scrape',
        title: 'Scraped from',
    },
    {
        data: 'created_at',
        title: 'Created',
    },
    {
        data: 'updated_at',
        title: 'Last update',
    },
    {
        data: 'act_delete',
        title: '',
    },
];

const actDelete = (url, index) => {
    axios.delete(url).then(
        () => {
            props.articles[index].act_delete = '';
        },
        (reason) => {
            console.error(reason);
        }
    )
}

const getDomain = (url) => {
    let uri = new URL(url);
    return uri.host;
}
</script>

<template>
    <Head title="Scrape List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scrape List</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <DataTable :data="articles" :columns="dtColumns" class="table-auto">
                            <template #column-2="prop">
                                <a :href="prop.cellData">{{ getDomain(prop.cellData) }}</a>
                            </template>
                            <template #column-7="prop">
                                <DangerButton v-if="prop.cellData" @click="actDelete(prop.cellData, prop.rowIndex)">Delete</DangerButton>
                            </template>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
