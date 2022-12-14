<template>
    <div class="container p-3">
        <div class="header">
            <h3 class="text-center">Confirmar Compra</h3>
        </div>
        <div class="content p-4">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-7">
                    <img :src="product.picture ? product.picture : '/images/img-logo-empresa.png'" class="card-img-top" :alt="product.product_name">
                </div>
                <div class="col-12 col-md-5 col-lg-5">
                    <div class="text-category mt-2">
                        <p class="m-0">{{product.category.category_name}}</p>
                    </div>
                    <div class="title-product">
                        <h3>{{product.product_name}}</h3>
                        <h5 class="fw-bold price-product">${{product.price}}</h5>
                    </div>
                    <div class="stock">
                        <span :class="`badge badge-${product.stock < 1 ? 'danger':'success'} m-0`">En Stock {{ product.stock }}</span>
                    </div>
                    <div class="quantity mt-2" v-if="product.stock > 0">
                        <input type="number" min="1" :max="product.stock" class="form-control w-25" v-model="quantity">
                    </div>
                    <div class="text-description mb-4 mt-1">
                        {{ product.product_description }}
                    </div>
                    <div class="button-vender ">
                        <p class="text-danger mb-0" v-if="product.stock === 0">No hay unidades disponibles en stock</p>
                        <button :disabled="product.stock === 0" class="btn btn-primary w-100" @click="saleProduct()">Vender</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
    name: "ModalPayProduct",
    props:['product'],
    data(){
      return{
          quantity: 1,
      }
    },
    methods:{

        /*=============================================
         MÉTODO PARA VENDER EL PRODUCTO
        =============================================*/
        async saleProduct(){

            Swal.fire({
                title: 'Confirmación',
                text: `¿Esta seguro de vender ${this.quantity} ${this.product.product_name}?`,
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
                    await axios.post(`/api/sale-product/${this.product.id_product}/${parseInt(this.quantity)}`).then(resp =>{
                        this.$toast.success(`${this.product.product_name} vendido exitosamente!`);
                        this.$vs.loading.close()
                        eventBus.$emit('updateListProducts')
                    }).catch(e =>{
                        this.$vs.loading.close()
                        console.log(e)
                        this.$toast.error("Error al vender el producto. Consulte al administrador");
                    })
                }
            })


        }
    }
}
</script>

<style scoped>

</style>
