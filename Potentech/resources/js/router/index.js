import { createWebHistory, createRouter } from 'vue-router'
import store from '@/store'

/* Guest Component */
const Login = () => import('@/components/Login.vue')
const Register = () => import('@/components/Register.vue')
/* Guest Component */

/* Layouts */
const DahboardLayout = () => import('@/components/layouts/Default.vue')
/* Layouts */

/* Authenticated Component */
const Dashboard = () => import('@/components/Dashboard.vue')
/* Authenticated Component */
const CreateRoom = () => import('@/components/teacher/CreateRoom.vue')
const DisconnectionPage = () => import('@/components/teacher/Disconnect.vue')
const JoinRoom = () => import('@/components/student/JoinRoom.vue')
const NotAvailable = () => import('@/components/404.vue')
const RoomCreated = () => import('@/components/teacher/RoomCreated.vue')


const routes = [
    {
        name: "404",
        path: "/not-available",
        component: NotAvailable,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        path: "/",
        component: DahboardLayout,
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "dashboard",
                path: '/',
                component: Dashboard,
                meta: {
                    title: `Dashboard`
                }
            }
        ]
    },
    {
        path: "/create-room",
        component: DahboardLayout,
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "create-room",
                path: '/create-room',
                component: CreateRoom,
                meta: {
                    title: `Create Room`
                }
            }
        ]
    },
    {
        path: "/join-room",
        component: DahboardLayout,
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "join-room",
                path: '/join-room',
                component: JoinRoom,
                meta: {
                    title: `Join Room`
                }
            }
        ]
    },
    {
        path: "/room/:id",
        component: DahboardLayout,
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "room",
                path: '/room/:roomId',
                component: RoomCreated,
                meta: {
                    title: `Room Created`
                }
            }
        ]
    },
    {
        name: "disconnection-page",
        path: "/disconnection-page",
        component: DisconnectionPage,
        meta: {
            middleware: "auth",
            title: `Disconnection Page`
        }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "dashboard" })
        }
        next()
    } else {
        if (store.state.auth.authenticated) {
            next()
        } else {
            next({ name: "login" })
        }
    }
})

export default router