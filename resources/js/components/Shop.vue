<template>
    <div>
        <div class="row pt-4 pb-4">
            <div class="col-12 d-flex justify-content-between">
                <h2>Productos</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-lg-4 col-md-4" v-for="product in products" :key="product.id_product">
                <div class="mb-4">
                    <div class="card">
                        <img :src="product.picture ? product.picture : '/images/img-logo-empresa.png'" class="card-img-top" :alt="product.product_name">
                        <div class="card-body">
                            <p class="m-0">{{ product.category.category_name }}</p>
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">{{ product.product_name }}</h5>
                                <h5 class="fw-bold price-product">${{ product.price }}</h5>
                            </div>

                            <p class="card-text text-truncate">{{ product.product_description }}</p>
                            <button class="btn btn-primary w-100" @click="openModal(product)">Ver Producto</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import ModalPayProduct from "./ModalPayProduct";
import {bus} from "../app";

export default {
    name: "Shop",
    data() {
        return {
            products: [],
        }
    },
    methods: {
        /*=============================================
         ABRIR MODAL PARA VENDER EL PRODUCTO
        =============================================*/
        openModal(product) {
            this.$FModal.show(
                {
                    placement: 'center top',
                    component: ModalPayProduct
                },
                {
                    product: product,
                }
            )
        },
        /*=============================================
         OBTENEMOS TODOS LOS PRODUCTOS
        =============================================*/
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
        /* Evento que permite actualizar la lista de productos luego que se realice una venta exitosamente*/
        setTimeout(() => {
            eventBus.$on('updateListProducts', () => {
                this.getProducts()
            })
        }, 200)
        this.getProducts() //Obtenemos todos los productos
    }
}
</script>

<style scoped>

</style>
