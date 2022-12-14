<template>
    <div class="p-5">
        <h3 class="text-center">{{ edit ? 'Editar' : 'Crear' }} Producto</h3>
        <div class="row mt-3">
            <div class="col-12 col-lg-6 col-md-6 mb-3">
                <div class="form-group">
                    <label for="product_name" class="form-label" :class="{ 'text-danger': $v.form.name.$error }">Nombre
                        Producto <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        v-model="form.name"
                        class="form-control"
                        :class="[{ 'is-invalid': $v.form.name.$error }]"
                        placeholder="nombre producto">
                    <!--                    <small id="emailHelp" class="form-text text-danger">We'll never share your email with anyone else.</small>-->
                </div>
            </div>
            <div class="col-12 col-lg-6 col-md-6 mb-3">
                <div class="form-group">
                    <label for="product_reference" class="form-label"
                           :class="{ 'text-danger': $v.form.reference.$error }">Referencia <span
                        class="text-danger">*</span></label>
                    <input
                        type="text"
                        v-model="form.reference"
                        class="form-control"
                        :class="[{ 'is-invalid': $v.form.reference.$error }]"
                        placeholder="referencia producto">
                    <!--                    <small id="emailHelp" class="form-text text-danger">We'll never share your email with anyone else.</small>-->
                </div>
            </div>

            <div class="col-12 col-lg-6 col-md-6 mb-3">
                <div class="form-group">
                    <label for="product_name" class="form-label" :class="{ 'text-danger': $v.form.price.$error }">Precio
                        <span class="text-danger">*</span></label>
                    <!--                    <money-->
                    <!--                        :class="[{ 'is-invalid': $v.form.price.$error }]"-->
                    <!--                        class="form-control"-->
                    <!--                        v-bind="money"-->
                    <!--                        v-model="form.price"></money>-->
                    <input
                        type="number"
                        v-model="form.price"
                        class="form-control"
                        min="500"
                        :class="[{ 'is-invalid': $v.form.price.$error }]"
                        placeholder="precio producto">
                    <!--                    <small id="emailHelp" class="form-text text-danger">We'll never share your email with anyone else.</small>-->
                </div>
            </div>
            <div class="col-12 col-lg-6 col-md-6 mb-3">
                <div class="form-group">
                    <label for="product_weight" class="form-label" :class="{ 'text-danger': $v.form.weight.$error }">Peso
                        <span class="text-danger">*</span></label>
                    <input
                        type="number"
                        v-model="form.weight"
                        class="form-control"
                        min="1"
                        :class="[{ 'is-invalid': $v.form.weight.$error }]"
                        placeholder="peso producto">
                    <!--                    <small id="emailHelp" class="form-text text-danger">We'll never share your email with anyone else.</small>-->
                </div>
            </div>
            <div class="col-12 col-lg-6 col-md-6 mb-3">
                <div class="form-group">
                    <label for="product_category" class="form-label"
                           :class="{ 'text-danger': $v.form.category.$error }">Seleccione la Categoría <span
                        class="text-danger">*</span></label>
                    <multiselect
                        :class="{ 'is-invalid': $v.form.category.$error }"
                        v-model="form.category"
                        :options="categories"
                        :searchable="false"
                        :close-on-select="true"
                        :custom-label="nameSelect"
                        track-by="id_category"
                        selectedLabel="Seleccionado"
                        deselectLabel=""
                        selectLabel="Selecciona"
                        :show-labels="true"
                        placeholder="Buscar categoría..."></multiselect>
                    <!--                    <small id="emailHelp" class="form-text text-danger">We'll never share your email with anyone else.</small>-->
                </div>
            </div>
            <div class="col-12 col-lg-6 col-md-6 mb-3">
                <div class="form-group">
                    <label for="product_stock" class="form-label" :class="{ 'text-danger': $v.form.stock.$error }">Stock
                        <span class="text-danger">*</span></label>
                    <input
                        type="number"
                        v-model="form.stock"
                        class="form-control"
                        min="1"
                        :class="[{ 'is-invalid': $v.form.stock.$error }]"
                        placeholder="stock producto">
                    <!--                    <small id="emailHelp" class="form-text text-danger">We'll never share your email with anyone else.</small>-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="product_description" class="form-label"
                           :class="{ 'text-danger': $v.form.description.$error }">Descripción
                        <span class="text-danger">*</span></label>
                    <textarea
                        class="form-control"
                        v-model="form.description"
                        :class="[{ 'is-invalid': $v.form.description.$error }]"
                        rows="3"
                        placeholder="descripción producto"
                    >

                    </textarea>
                    <!--                    <small id="emailHelp" class="form-text text-danger">We'll never share your email with anyone else.</small>-->
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    <label for="product_picture" class="form-label">Imagen del Producto (opcional)</label>
                    <upload-picture-component></upload-picture-component>

                    <!--                    <small id="emailHelp" class="form-text text-danger">We'll never share your email with anyone else.</small>-->
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-end">
                <button v-if="!edit" class="btn btn-success" @click="saveProduct">Crear Producto</button>
                <button v-if="edit" class="btn btn-success" @click="editProduct">Editar Producto</button>
            </div>
        </div>
    </div>
</template>

<script>
import {between, required} from "vuelidate/lib/validators";
import Swal from "sweetalert2";
import UploadPicture from "./UploadPicture";

export default {
    name: "ModalCreateProduct",
    components: {UploadPicture},
    data() {
        return {
            categories: [],
            idProduct: null,
            form: {
                name: String(),
                reference: String(),
                price: null,
                weight: null,
                category: null,
                stock: null,
                description: String()
            },
            money: {
                decimal: '.',
                thousands: '.',
                prefix: '',
                suffix: '',
                precision: 0,
                masked: true
            }
        }
    },
    props: ['product', 'edit'],
    validations: {
        form: {
            name: {required},
            reference: {required},
            price: {required, between: between(1, 100000)},
            weight: {required},
            category: {required},
            stock: {required},
            description: {required},
        },
    },

    methods: {
        /*=============================================
         MÉTODO RETONAR EL NOMBRE DE LA CATEGORÍA
        =============================================*/
        nameSelect({category_name}) {
            return `${category_name}`
        },
        /*=============================================
         MÉTODO PARA EDITAR EL PRODUCTO
        =============================================*/
        editProduct(){
            this.$v.form.$touch();
            if (this.$v.$invalid) {
                this.$toast.error("Verifique los campos obligatorios ");
                return
            }

            Swal.fire({
                title: 'Confirmación',
                text: `¿Esta seguro de actualizar el producto?`,
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
                    await axios.post(`/api/editar-product/${this.idProduct}`, this.form).then(resp => {
                        eventBus.$emit('savePicture');
                        this.$vs.loading.close()
                        this.$toast.success(`Producto editato exitosamente!`);
                        setTimeout(() => {
                            eventBus.$emit('updateListProducts')
                        }, 500)

                    }).catch(e => {
                        this.$vs.loading.close()
                        console.log(e)
                        this.$toast.error("Error al editar el producto. Consulte al administrador");
                    })
                }
            })
        },
        /*=============================================
         MÉTODO PARA GUARDAR EL PRODUCTO
        =============================================*/
        async saveProduct() {
            this.$v.form.$touch();
            if (this.$v.$invalid) {
                this.$toast.error("Verifique los campos obligatorios ");
                return
            }

            Swal.fire({
                title: 'Confirmación',
                text: `¿Esta seguro de crear el producto`,
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
                    await axios.post(`/api/create-product`, this.form).then(resp => {
                        eventBus.$emit('savePicture');
                        this.$vs.loading.close()
                        this.$toast.success(`Producto creado exitosamente!`);
                        setTimeout(() => {
                            eventBus.$emit('updateListProducts')
                        }, 1000)

                    }).catch(e => {
                        this.$vs.loading.close()
                        console.log(e)
                        this.$toast.error("Error al crear el producto. Consulte al administrador");
                    })
                }
            })
        },
        /*=============================================
         MÉTODO PARA OBTENER TODAS LAS CATEGORÍAS
        =============================================*/
        async getCategories() {
            await axios.get('/api/get-categories').then(resp => {
                this.categories = resp.data.data
            }).catch(e => {
                this.$vs.loading.close()
                console.log(e)
                this.$toast.error("Error al obtener las categorías. Consulte al administrador");
            })
        }
    },
    mounted() {
        this.getCategories()
        if (this.edit) {
            this.$vs.loading({
                color: '#544646',
                text: 'Espere por favor...'
            })
            setTimeout(() => {
                this.idProduct = this.product.id_product
                this.form.name = this.product.product_name
                this.form.reference = this.product.reference
                this.form.price = this.product.price
                this.form.stock = this.product.stock
                this.form.weight = this.product.weight
                this.form.description = this.product.product_description
                this.form.category = this.product.category
                this.$vs.loading.close()
            }, 500)

        }
    }
}
</script>

<style scoped>

</style>
