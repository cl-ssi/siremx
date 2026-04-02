<template>
    <div>Cerrando sesión...</div>
</template>

<script>
export default {
    name: 'Logout',
    
    mounted() {
        this.logout();
    },
    
    methods: {
        async logout() {
            try {
                // Llamar al backend para destruir sesión
                await this.$axios.get('/authenticate/logout');
            } catch (e) {
                console.error('Error en logout API:', e);
            } finally {
                // Limpiar storage
                localStorage.clear();
                sessionStorage.clear();
                
                // Forzar recarga completa a login (evita problemas de chunk)
                window.location.href = '/auth/login';
            }
        }
    }
}
</script>