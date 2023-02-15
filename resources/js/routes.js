import AllPatients from './components/AllPatients.vue';
import CreatePatient from './components/CreatePatient.vue';
import EditPatient from './components/EditPatient.vue';
 
export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllPatients
    },
    {
        name: 'create',
        path: '/create',
        component: CreatePatient
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditPatient
    }
];