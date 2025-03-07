import { ref, onMounted } from "vue";
import axios from "../../axios.js";
import FormatCurrency from "../../composables/FormatCurrency.js";
import { ElMessage } from "element-plus";
import formatCurrency from "../../composables/FormatCurrency.js";
import { computed } from "vue";
import { supabase } from "../../connection.js";
const emit = defineEmits(["cerrar", "overlay", "deleted"]);
const selectedClient = ref(null);
const clients = ref([]);
const overlay = ref(false);
const tab = ref(null);
const loading = ref(false);

export default {
	setup() {
		const props = defineProps({
			id: {
				type: Number,
				required: true,
			},
		});

		const form = ref({
			tarjeta: 0,
			transferencia: 0,
			efectivo: 0,
		});

		const venta = ref({});

		const AsociateSale = async () => {
			overlay.value = true;
			let response = await axios
				.put(`venta/${props.id}`, {
					cliente_id: selectedClient.value.id,
				})
				.then((response) => {
					console.log(response.data.data, "dahebbe");

					overlay.value = false;
					venta.value = response.data.data;
					console.log(venta.value);
					ElMessage({
						type: "success",
						message: "Venta actualizada",
					});
					tab.value = 3;
				});

			console.log("AsociateSale", venta.value);
		};

		const deleteSale = async (ventum) => {
			axios.delete(`/venta/${ventum}`).then(({ data }) => {
				emit("cerrar");
				emit("deleted");
			});
		};

		const fetchVenta = async () => {
			try {
				overlay.value = true;

				const { data } = await axios.get(`/venta/${props.id}`);
				// const {data, error } = await supabase.from('venta').select()
				venta.value = data.data;
				clients.value = data.clientes;

				overlay.value = false;
			} catch (error) {
				console.error("Error al obtener la venta:", error);
				overlay.value = false;
			}
			console.log("fetchVenta", venta.value);
		};

		const pago = computed(() => {
			const total = venta.value.total || 0;
			const efectivo = form.value.efectivo || 0;
			const tarjeta = form.value.tarjeta || 0;
			const transferencia = form.value.transferencia || 0;

			const resta = total - efectivo - tarjeta - transferencia;
			const cambio = resta < 0 ? -resta : 0;

			console.log("pago", venta.value);

			return {
				total,
				resta: resta > 0 ? resta : 0,
				cambio,
			};
		});

		const payment = async () => {
			const data = await axios
				.put(`/pagos-back/${props.id}`, form.value)
				.then(({ data }) => {
					ElMessage({
						type: "success",
						message: "venta cobrada",
					});
					emit("deleted");
					console.log(data);
				});

			console.log(form.value);
		};

		const calculate = () => {
			pago.value.total = venta.value.total;
			pago.value.resta =
				venta.value.total -
				form.value.efectivo -
				form.value.transferencia -
				form.value.tarjeta;
			if (pago.value.resta <= 0) {
				pago.value.cambio = pago.value.resta * -1;
				pago.value.resta = 0;
			} else {
				pago.value.cambio = 0;
			}
			return pago.value;
		};

		onMounted(() => {
			fetchVenta();
		});
	},
};
