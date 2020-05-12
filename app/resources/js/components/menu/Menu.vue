<template>
    <sidebar-menu :menu="menu" :collapsed="true" />
</template>

<script>
    export default {
        props: ["admin"],
        data() {
            let menu_data = {
                collapsed: true,
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
                        href: '/documentation/index',
                        title: 'Docs',
                        icon: 'fa fa-file'
                    }
                ]
            }
            if(this.admin == 1) {
            //if(true) {
                menu_data.menu.push(
                    {
                        href: '/apiregistration',
                        title: 'API',
                        icon: 'fa fa-bolt'
                    },
                    {
                        title: 'Admin',
                        icon: 'fa fa-bahai',
                        child: [
                            {
                                href: '/admin/user',
                                title: 'Users',
                                icon: 'fa fa-users'
                            }
                        ]
                    }
                )
            }
            return menu_data;
        }
    }
</script>
