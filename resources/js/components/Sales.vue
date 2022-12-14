<template>
    <div>
        <div class="row pt-4 pb-4">
            <div class="col-12 d-flex justify-content-between">
                <h2>Ventas</h2>
            </div>
        </div>
        <div class="row" v-if="sales.length > 0">
            <div class="col-12">
                <div class="mb-4">
                    <div class="card">
                        <div class="card-body">
                            <vue-good-table
                                styleClass="vgt-table striped table-hover"
                                :columns="columns"
                                :line-numbers="true"
                                :rows="sales"
                                :fixed-header="true"
                                max-height="500px"
                                :pagination-options="{
    enabled: true,
    mode: 'records',
    perPage: 20,
    perPageDropdown: [10, 20, 50],
    dropdownAllowAll: true,
    setCurrentPage: 1,
    jumpFirstOrLast : true,
    firstLabel : 'Primera Página',
    lastLabel : 'Última Página',
    nextLabel: 'Siguiente',
    prevLabel: 'Anterior',
    ofLabel: 'of',
    rowsPerPageLabel: 'Productos por página',
    ofLabel: 'of',
    pageLabel: 'page', // for 'pages' mode
    allLabel: 'Todos',
  }">
                                <template slot="table-row" slot-scope="props">
                                    <div v-if="props.column.field === 'product.product_name'">
                                        <p class="m-0"> {{ props.row.product.product_name }}</p>
                                    </div>
                                    <div v-if="props.column.field === 'product.category.category_name'">
                                        <p> {{ props.row.product.category.category_name }}</p>
                                    </div>
                                    <div v-if="props.column.field === 'total'">
                                        <p class="price-product">${{ props.row.total }}</p>
                                    </div>
                                    <div v-if="props.column.field === 'quantity'">
                                        <p>{{ props.row.quantity }}</p>
                                    </div>
                                    <div v-if="props.column.field === 'created_at'">
                                        <p style="text-transform: capitalize">{{ moment(props.row.created_at).locale('es').format("MMMM DD YYYY") }}</p>
                                    </div>
                                </template>
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-12 d-flex justify-content-center">
                <h4>En el momento no hay ventas</h4>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <a class="btn btn-primary" href="/">Ir a productos</a>
            </div>

        </div>
    </div>
</template>

<script>
import moment from "moment";
require("moment/min/locales.min");

export default {
    name: "Sales",
    data() {
        return {
            moment: moment,
            columns: [
                {
                    label: 'Producto',
                    field: 'product.product_name',
                    filterOptions: {
                        enabled: true, // enable filter for this column
                        placeholder: 'Buscar por producto',
                    }
                },
                {
                    label: 'Categoría',
                    field: 'product.category.category_name',
                    filterOptions: {
                        enabled: true, // enable filter for this column
                        placeholder: 'Buscar por categoría',
                    }
                },
                {
                    label: 'Total',
                    field: 'total',
                },
                {
                    label: 'Cantidad',
                    field: 'quantity',
                },

                {
                    label: 'Fecha de Creación',
                    field: 'created_at',
                },
            ],

            sales: [],
        }
    },

    methods: {
        async getSales() {
            this.$vs.loading({
                color: '#544646',
                text: 'Espere por favor...'
            })
            await axios.get('/api/get-sales').then(resp => {
                this.sales = resp.data.data
                this.$FModal.hide()
                this.$vs.loading.close()
            }).catch(e => {
                this.$vs.loading.close()
                console.log(e)
                this.$toast.error("Error al obtener las ventas. Consulte al administrador");
            })
        }
    },
    mounted() {
        this.getSales()
    }
}
</script>

<style scoped>

</style>
