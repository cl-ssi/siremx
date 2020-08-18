<template>
    <div class="login-page bg-sismam ">
        <transition name="slide-fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    export default {
    }
</script>

<style>
    .bg-sismam {
        background: rgba(147,206,222,1);
        background: -moz-radial-gradient(center, ellipse cover, rgba(147,206,222,1) 0%, rgba(73,185,189,1) 100%);
        background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(147,206,222,1)), color-stop(100%, rgba(73,185,189,1)));
        background: -webkit-radial-gradient(center, ellipse cover, rgba(147,206,222,1) 0%, rgba(73,185,189,1) 100%);
        background: -o-radial-gradient(center, ellipse cover, rgba(147,206,222,1) 0%, rgba(73,185,189,1) 100%);
        background: -ms-radial-gradient(center, ellipse cover, rgba(147,206,222,1) 0%, rgba(73,185,189,1) 100%);
        background: radial-gradient(ellipse at center, rgba(147,206,222,1) 0%, rgba(73,185,189,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#93cede', endColorstr='#49b9bd', GradientType=1 );
    }
</style>

