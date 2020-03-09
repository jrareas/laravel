<template>
    <sidebar-menu :menu="menu" />
</template>

<script>
    export default {
        data() {
            return {
                menu: [
                    {
                        href: '/info',
                        title: 'Info',
                        icon: 'fa fa-user'
                    },
                    {
                        href: '/dashboard',
                        title: 'Dashboard',
                        icon: 'fa fa-solar-panel'
                    },
                    {
                        href: '/charts',
                        title: 'Charts',
                        icon: 'fa fa-chart-area'
                    }
                ]
            }
        }
    }
</script>
