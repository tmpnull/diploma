<template>
    <div>
        <md-table class="timetable" v-model="timetableToShow">
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
                        <label>Выберите дату</label>
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

            <md-table-row slot="md-table-row" slot-scope="{item}" class="timetable-row">
                <md-table-cell md-label="Группа">
                    {{item[0].group.name}}
                </md-table-cell>

                <md-table-cell :md-label="daysOfWeek[n]" v-for="(n, index) in 5" :key="index">
                    <md-card>
                        <md-list v-for="(h, index) in 4" :key="index" class="md-double-line">
                            <md-subheader>
                                {{courseTime[h]}}
                            </md-subheader>

                            <md-list-item v-for="course in item"
                                          :key="course.id"
                                          v-if="(course.number === h
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

                            <md-list-item v-for="course in item"
                                          :key="course.id"
                                          v-if="(course.number === h
                            && course.day_of_week === n
                            && (course.is_numerator === 0))">
                                <div>
                                    <span>{{course.audience.name}}({{course.audience.building.abbreviation}})</span>
                                </div>

                                <div class="md-list-item-text">
                                    <span>{{course.course.name}}</span>
                                    <span>{{course.course.teacher.user.surname}} {{course.course.teacher.user.name}} {{course.course.teacher.user.patronymic}}</span>
                                </div>

                                <div>
                                    <span>{{course.is_numerator === 0 ? 'Знаменатель' : ''}}</span>
                                </div>
                            </md-list-item>

                            <md-divider v-if="h !== 4"></md-divider>
                        </md-list>
                    </md-card>
                </md-table-cell>
            </md-table-row>

            <md-table-empty-state
                md-label="Не найдено расписание"
                :md-description="`Не найдено расписание для группы на '${this.selectedDate}'. Попробуйте другую дату.`"
                v-show="!loading"
            >
            </md-table-empty-state>

            <md-table-empty-state
                v-show="loading"
            >
                <md-progress-spinner :md-diameter="50" :md-stroke="5" md-mode="indeterminate"></md-progress-spinner>
            </md-table-empty-state>
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
                daysOfWeek: {
                    1: 'Понедельник',
                    2: 'Вторник',
                    3: 'Среда',
                    4: 'Четверг',
                    5: 'Пятница',
                },
                courseTime: {
                    1: '8:00 - 9:35',
                    2: '9:50 - 11:25',
                    3: '11:55 - 13:30',
                    4: '13:45 - 15:20',
                },
            };
        },
        methods: {
            onSearch: function () {
                this.loading = true;

                if (!this.selectedGroup) {
                    this.$store.dispatch('timetable/getTimetable');
                    return;
                }

                try {
                    this.$store.dispatch('timetable/getByGroupWithParams', {
                        id: this.selectedGroup,
                        query: {
                            date: moment(this.selectedDate).format('YYYY-MM-DD'),
                        },
                    });
                } catch (e) {
                    this.loading = false;
                    console.log(e);
                }

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
    .timetable {
        &-row {
            vertical-align: top;

            .md-list-item-text {
                width: 15rem;
                margin-left: 1rem;
                margin-right: 1rem;
                white-space: pre-wrap;
            }

            & /deep/ .md-table-cell:nth-child(1) {
                vertical-align: middle;
            }
        }

        & /deep/ .md-table-head {
            text-align: center;
        }
    }
</style>
