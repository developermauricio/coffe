<template>
    <div>
        <div class="row pt-4 pb-4">
            <div class="col-12 d-flex justify-content-between">
                <h2>Administrar</h2>
                <button class="btn btn-success" @click="openModalCreate">Agregar Producto</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12" >
                <div class="mb-4">
                    <div class="card">
                        <div class="card-body">
                            <vue-good-table
                                styleClass="vgt-table striped table-hover"
                                :columns="columns"
                                :line-numbers="true"
                                :rows="products"
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
                                    <div v-if="props.column.field === 'product_name'">
                                        <div class="d-flex align-items-center">
                                            <img :src="props.row.picture ? props.row.picture : '/images/img-logo-empresa.png'" width="60" class="img-table" :alt="props.row.product_name">
                                            <p class="m-0"> {{ props.row.product_name }}</p>
                                        </div>

                                    </div>
                                    <div v-if="props.column.field === 'category.category_name'">
                                        <p>{{ props.row.category.category_name }}</p>
                                    </div>
                                    <div v-if="props.column.field === 'price'">
                                        <p class="price-product">${{ props.row.price }}</p>
                                    </div>
                                    <div v-if="props.column.field === 'weight'">
                                        <p>{{ props.row.weight }} kg</p>
                                    </div>
                                    <div v-if="props.column.field === 'reference'">
                                        <p>{{ props.row.reference }}</p>
                                    </div>
                                    <div v-if="props.column.field === 'stock'">
                                        <p><span :class="`badge badge-${ props.row.stock < 1 ? 'danger':'success'} m-0`">En Stock {{  props.row.stock }}</span></p>
                                    </div>
                                    <div v-if="props.column.field === 'created_at'">
                                        <p style="text-transform: capitalize">{{ moment(props.row.created_at).locale('es').format("MMMM DD YYYY") }}</p>
                                    </div>
                                    <div v-if="props.column.field === 'actions'">
                                        <div class="d-flex">
                                            <button class="btn btn-primary" style="margin-right: 0.7rem" @click="editProduct(props.row)">Editar</button>
                                            <button class="btn btn-primary" @click="deleteProduct(props.row)">Eliminar</button>
                                        </div>
                                    </div>
                                </template>
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ModalCreateProduct from "./ModalCreateProduct";
require("moment/min/locales.min");
import moment from 'moment';
import Swal from "sweetalert2";
export default {
    name: "Admin",
    data() {
        return {
            moment: moment,
            columns: [
                {
                    label: 'Producto',
                    field: 'product_name',
                    filterOptions: {
                        enabled: true, // enable filter for this column
                        placeholder: 'Buscar por producto',
                    }
                },
                {
                    label: 'Categoría',
                    field: 'category.category_name',
                    filterOptions: {
                        enabled: true, // enable filter for this column
                        placeholder: 'Buscar por categoría',
                    }
                },
                {
                    label: 'Precio',
                    field: 'price',
                },
                {
                    label: 'Peso',
                    field: 'weight',
                },
                {
                    label: 'Referencia',
                    field: 'reference',
                },
                {
                    label: 'Stock',
                    field: 'stock',
                },
                {
                    label: 'Fecha de Creación',
                    field: 'created_at',
                },
                {
                    label: 'Acciones',
                    field: 'actions',
                    sortable: false,
                },
            ],

            products: [],
        }
    },
    methods: {
        openModalCreate(product) {
            this.$FModal.show(
                {
                    placement: 'center top',
                    component: ModalCreateProduct
                },
                {
                    product: null,
                    edit: false
                }
            )
        },
        editProduct(product) {
            this.$FModal.show(
                {
                    placement: 'center top',
                    component: ModalCreateProduct
                },
                {
                    product: product,
                    edit: true
                }
            )
        },

        async deleteProduct(product){
            Swal.fire({
                title: 'Confirmación',
                text: `¿Esta seguro de eliminar el producto`,
                confirmButtonColor: "#792141FF",
                cancelButtonColor: "rgba(0,0,0,0.73)",
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                customClass: "swal-confirmation",
                showCancelButton: true,
                reverseButtons: true,
                allowOutsideClick: false,
            }).then(async result => {
                if (result.value) {
                    this.$vs.loading({
                        color: '#544646',
                        text: 'Espere por favor...'
                    })
                    await axios.delete(`/api/edit-product/${product.id_product}`).then(resp => {

                        this.$vs.loading.close()
                        this.$toast.success(`Producto eliminado exitosamente!`);
                        setTimeout(() => {
                            this.getProducts()
                        }, 500)

                    }).catch(e => {
                        this.$vs.loading.close()
                        console.log(e)
                        this.$toast.error("Error al eliminar el producto. Consulte al administrador");
                    })
                }
            })
        },

        async getProducts() {
            this.$vs.loading({
                color: '#544646',
                text: 'Espere por favor...'
            })
            await axios.get('/api/get-products').then(resp => {
                this.products = resp.data.data
                this.$FModal.hide()
                this.$vs.loading.close()
            }).catch(e => {
                this.$vs.loading.close()
                console.log(e)
                this.$toast.error("Error al obtener los productos. Consulte al administrador");
            })
        }
    },
    mounted() {
        setTimeout(() => {
            eventBus.$on('updateListProducts', () => {
                this.getProducts()
            })
        }, 200)
        this.getProducts()
    }
}
</script>

<style scoped>

</style>
