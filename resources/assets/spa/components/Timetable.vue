<template>
    <div>
        <md-table class="timetable">
            <md-table-toolbar>
                <div class="md-toolbar-section-start">
                    <h1 class="md-title">Фильтр</h1>
                </div>

                <div>
                    <md-button
                        class="md-primary"
                        :disabled="loading"
                        v-on:click="onSearch"
                    >
                        <span>Найти</span>
                    </md-button>
                </div>

                <div v-show="selectedGroup">
                    <md-datepicker v-model="selectedDate">
                        <label>Select date</label>
                    </md-datepicker>
                </div>

                <div class="md-toolbar-section-end">
                    <md-field>
                        <label for="group">Группа</label>
                        <md-select v-model="selectedGroup" name="group" id="group">
                            <md-option>
                                Очистить
                            </md-option>
                            <md-option
                                v-for="group in groups"
                                :key="group.id"
                                v-bind:value="group.id"
                            >
                                {{group.name}}
                            </md-option>
                        </md-select>
                    </md-field>
                </div>
            </md-table-toolbar>

            <md-table-row>
                <md-table-head>Группа</md-table-head>
                <md-table-head>Понедельник</md-table-head>
                <md-table-head>Вторник</md-table-head>
                <md-table-head>Среда</md-table-head>
                <md-table-head>Четверг</md-table-head>
                <md-table-head>Пятница</md-table-head>
            </md-table-row>

            <md-table-empty-state
                md-label="No timetable found"
                :md-description="`Не найдено расписание для группы на '${this.selectedDate}'. Попробуйте другую дату.`">
            </md-table-empty-state>

            <md-table-row v-show="loading">
                <md-table-cell colspan="6">
                    <md-progress-spinner :md-diameter="50" :md-stroke="5" md-mode="indeterminate"></md-progress-spinner>
                </md-table-cell>
            </md-table-row>

            <md-table-row v-for="group in timetableToShow" :key="group[0].group_id" class="timetable-row">
                <md-table-cell>
                    {{group[0].group.name}}
                </md-table-cell>

                <md-table-cell v-for="(n, index) in 5" :key="index">
                    <md-card>
                        <md-list class="md-double-line">

                            <md-subheader>8:00 - 9:35</md-subheader>

                            <md-list-item v-for="course in group"
                                          :key="course.id"
                                          v-if="(course.number === 1
                            && course.day_of_week === n
                            && (course.is_numerator === 1 || course.is_numerator === null))">
                                <div>
                                    <span>{{course.audience.name}}({{course.audience.building.abbreviation}})</span>
                                </div>

                                <div class="md-list-item-text">
                                    <span>{{course.course.name}}</span>
                                    <span>{{course.course.teacher.user.surname}} {{course.course.teacher.user.name}} {{course.course.teacher.user.patronymic}}</span>
                                </div>

                                <div>
                                    <span>{{course.is_numerator === 1 ? 'Числитель' : ''}}</span>
                                </div>
                            </md-list-item>

                            <md-list-item v-for="course in group"
                                          :key="course.id"
                                          v-if="(course.number === 1
                            && course.day_of_week === n
                            && course.is_numerator === 0)">
                                <div>
                                    <span>{{course.audience.name}}({{course.audience.building.abbreviation}})</span>
                                </div>

                                <div class="md-list-item-text">
                                    <span>{{course.course.name}}</span>
                                    <span>{{course.course.teacher.user.surname}} {{course.course.teacher.user.name}} {{course.course.teacher.user.patronymic}}</span>
                                </div>

                                <div>
                                    <span>Знаменатель</span>
                                </div>
                            </md-list-item>

                            <md-divider></md-divider>

                            <md-subheader>9:50 - 11:25</md-subheader>

                            <md-list-item v-for="course in group"
                                          :key="course.id"
                                          v-if="(course.number === 2
                            && course.day_of_week === n
                            && (course.is_numerator === 1 || course.is_numerator === null))">
                                <div>
                                    <span>{{course.audience.name}}({{course.audience.building.abbreviation}})</span>
                                </div>

                                <div class="md-list-item-text">
                                    <span>{{course.course.name}}</span>
                                    <span>{{course.course.teacher.user.surname}} {{course.course.teacher.user.name}} {{course.course.teacher.user.patronymic}}</span>
                                </div>

                                <div>
                                    <span>{{course.is_numerator === 1 ? 'Числитель' : ''}}</span>
                                </div>
                            </md-list-item>

                            <md-list-item v-for="course in group"
                                          :key="course.id"
                                          v-if="(course.number === 2
                            && course.day_of_week === n
                            && course.is_numerator === 0)">
                                <div>
                                    <span>{{course.audience.name}}({{course.audience.building.abbreviation}})</span>
                                </div>

                                <div class="md-list-item-text">
                                    <span>{{course.course.name}}</span>
                                    <span>{{course.course.teacher.user.surname}} {{course.course.teacher.user.name}} {{course.course.teacher.user.patronymic}}</span>
                                </div>

                                <div>
                                    <span>Знаменатель</span>
                                </div>
                            </md-list-item>

                            <md-divider></md-divider>

                            <md-subheader>11:55 - 13:30</md-subheader>

                            <md-list-item v-for="course in group"
                                          :key="course.id"
                                          v-if="(course.number === 3
                            && course.day_of_week === n
                            && (course.is_numerator === 1 || course.is_numerator === null))">
                                <div>
                                    <span>{{course.audience.name}}({{course.audience.building.abbreviation}})</span>
                                </div>

                                <div class="md-list-item-text">
                                    <span>{{course.course.name}}</span>
                                    <span>{{course.course.teacher.user.surname}} {{course.course.teacher.user.name}} {{course.course.teacher.user.patronymic}}</span>
                                </div>

                                <div>
                                    <span>{{course.is_numerator === 1 ? 'Числитель' : ''}}</span>
                                </div>
                            </md-list-item>

                            <md-list-item v-for="course in group"
                                          :key="course.id"
                                          v-if="(course.number === 3
                            && course.day_of_week === n
                            && course.is_numerator === 0)">
                                <div>
                                    <span>{{course.audience.name}}({{course.audience.building.abbreviation}})</span>
                                </div>

                                <div class="md-list-item-text">
                                    <span>{{course.course.name}}</span>
                                    <span>{{course.course.teacher.user.surname}} {{course.course.teacher.user.name}} {{course.course.teacher.user.patronymic}}</span>
                                </div>

                                <div>
                                    <span>Знаменатель</span>
                                </div>
                            </md-list-item>

                            <md-divider></md-divider>

                            <md-subheader>13:45 - 15:20</md-subheader>

                            <md-list-item v-for="course in group"
                                          :key="course.id"
                                          v-if="(course.number === 4
                            && course.day_of_week === n
                            && (course.is_numerator === 1 || course.is_numerator === null))">
                                <div>
                                    <span>{{course.audience.name}}({{course.audience.building.abbreviation}})</span>
                                </div>

                                <div class="md-list-item-text">
                                    <span>{{course.course.name}}</span>
                                    <span>{{course.course.teacher.user.surname}} {{course.course.teacher.user.name}} {{course.course.teacher.user.patronymic}}</span>
                                </div>

                                <div>
                                    <span>{{course.is_numerator === 1 ? 'Числитель' : ''}}</span>
                                </div>
                            </md-list-item>

                            <md-list-item v-for="course in group"
                                          :key="course.id"
                                          v-if="(course.number === 4
                            && course.day_of_week === n
                            && course.is_numerator === 0)">
                                <div>
                                    <span>{{course.audience.name}}({{course.audience.building.abbreviation}})</span>
                                </div>

                                <div class="md-list-item-text">
                                    <span>{{course.course.name}}</span>
                                    <span>{{course.course.teacher.user.surname}} {{course.course.teacher.user.name}} {{course.course.teacher.user.patronymic}}</span>
                                </div>

                                <div>
                                    <span>Знаменатель</span>
                                </div>
                            </md-list-item>

                        </md-list>
                    </md-card>

                </md-table-cell>
            </md-table-row>

        </md-table>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        name: 'Timetable',
        props: {
            timetable: Array,
            groups: Array,
        },
        data() {
            return {
                loading: true,
                selectedGroup: null,
                selectedDate: null,
                timetableToShow: [],
            };
        },
        methods: {
            onSearch: function () {
                if (!this.selectedGroup) {
                    this.$store.dispatch('timetable/getTimetable');
                    return;
                }

                this.$store.dispatch('timetable/getByGroupWithDate', {
                    id: this.selectedGroup,
                    date: moment(this.selectedDate).format('YYYY-MM-DD'),
                });
            },
        },
        watch: {
            groups: function (data) {
                this.loading = false;
            },
            timetable: function (data) {
                this.loading = false;
                this.timetableToShow = data;
            },
        },
    };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    .md-table {
        td,
        th {
            text-align: center;
        }
    }

    .timetable-row {
        td {
            vertical-align: top;
        }

        .md-list-item-text {
            width: 15rem;
            margin-left: 1rem;
            margin-right: 1rem;
            white-space: pre-wrap;
        }
    }
</style>
