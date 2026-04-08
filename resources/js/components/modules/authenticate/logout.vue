<template>
    <div>Cerrando sesión...</div>
</template>

<script>
export default {
    name: 'Logout',
    
    // NO usar mounted() - usar beforeCreate para ejecutar ANTES de que Vue renderice
    beforeCreate() {
        this.logout();
    },
    
    methods: {
        async logout() {
            try {
                // Intentar logout en backend
                await fetch('/authenticate/logout', {
                    method: 'GET',
                    credentials: 'include'
                });
            } catch (e) {
                console.error('Logout error:', e);
            } finally {
                // Limpiar TODO
                localStorage.clear();
                sessionStorage.clear();
                
                // Forzar recarga completa LIMPIA (evita chunks de Vue)
                window.location.replace('/auth/login');
            }
        }
    }
}
</script>