<template>
    <div>
        <Timetable v-bind:timetable="timetable" v-bind:groups="groups" />
    </div>
</template>

<script>
    // @ is an alias to /src
    import Timetable from '@/components/Timetable.vue';
    import { mapState } from 'vuex';

    export default {
        name: 'home',
        components: {
            Timetable,
        },
        computed: mapState({
            timetable: state => state.timetable.timetable,
            groups: state => state.timetable.groups,
        }),
        async mounted() {
            this.$store.dispatch('timetable/getTimetable');
        },
    };
</script>
