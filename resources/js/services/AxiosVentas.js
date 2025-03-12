import axios from "../axios"

export const getSales = async () => {
  try {
    const { data } = await axios.get("/venta");
    return data.data
  } catch (error) {
    console.error("Error al obtener ventas activas:", error);
    return error
  }
};

export const getPendientes = async () => {
  try {
    const { data } = await axios.get("/pendiente");
    console.log(data.data)
    return data.data
  } catch (error) {
    console.error("Error al obtener ventas pendientes:", error);
  } finally {
    OverlayValue.value = false;
  }
};