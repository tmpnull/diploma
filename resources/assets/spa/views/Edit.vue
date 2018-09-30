<template>
    <form novalidate class="md-layout md-alignment-center editForm" @submit.prevent="validateTimetable">
        <md-card class="md-layout-item md-size-75 md-small-size-100">
            <md-card-header>
                <div class="md-title">Добавить предмет в распиание</div>
            </md-card-header>

            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('day_of_week')">
                            <label for="day_of_week">День недели</label>
                            <md-select name="day_of_week" id="day_of_week" v-model="form.day_of_week" md-dense
                                       :disabled="sending">
                                <md-option v-for="(n, index) in 5" :key="index" :value="n">{{daysOfWeek[n]}}</md-option>
                            </md-select>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('number')">
                            <label for="number">Номер пары</label>
                            <md-select name="number" id="number" v-model="form.number" md-dense
                                       :disabled="sending">
                                <md-option v-for="(n, index) in 4" :key="index" :value="n">{{n}} - {{courseTime[n]}}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-switch v-model="form.is_first_semester" class="md-primary">
                            <small>Первый семестр</small>
                        </md-switch>
                    </div>

                    <div class="md-layout-item md-small-size-100">
                        <div>
                            <md-radio v-model="form.is_numerator" :value="true">Числитель</md-radio>
                            <md-radio v-model="form.is_numerator" :value="false">Знаменатель</md-radio>
                            <md-radio v-model="form.is_numerator" :value="null">Каждую неделю</md-radio>
                        </div>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('group_id')">
                            <label for="group_id">Номер группы</label>
                            <md-select name="group_id" id="group_id" v-model="form.group_id" md-dense
                                       :disabled="sending">
                                <md-option v-for="group in groups" :key="group.id" :value="group.id">{{group.name}}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('course_id')">
                            <label for="course_id">Предмет</label>
                            <md-select name="course_id" id="course_id" v-model="form.course_id" md-dense
                                       :disabled="sending">
                                <md-option v-for="course in courses" :key="course.id" :value="course.id">{{course.name}}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('audience_id')">
                            <label for="audience_id">Аудитория</label>
                            <md-select name="course_id" id="course_id" v-model="form.audience_id" md-dense
                                       :disabled="sending">
                                <md-option v-for="audience in audiences" :key="audience.id" :value="audience.id">
                                    {{audience.name}}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-progress-bar md-mode="indeterminate" v-if="sending" />

            <md-card-actions>
                <md-button type="submit" class="md-primary" :disabled="sending">Добавить предмет</md-button>
            </md-card-actions>
        </md-card>

        <md-snackbar :md-active.sync="success">Предмет "{{ lastTimetable }}" было успешно сохранен в расписании!
            <md-button class="md-primary" :md-duration="4000">Retry</md-button>
        </md-snackbar>
        <md-snackbar :md-active.sync="error" :md-duration="4000">Произошла ошибка при сохранении предмета!
            <md-button class="md-primary" :md-duration="4000">Retry</md-button>
        </md-snackbar>
    </form>
</template>

<script>
    import { mapState } from 'vuex';
    import { validationMixin } from 'vuelidate';
    import {
        required,
    } from 'vuelidate/lib/validators';

    export default {
        name: 'edit',
        mixins: [validationMixin],
        data: () => ({
            form: {
                day_of_week: null,
                number: null,
                is_first_semester: true,
                is_numerator: null,
                group_id: null,
                course_id: null,
                audience_id: null,
            },
            lastTimetable: null,
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
        }),
        validations: {
            form: {
                day_of_week: {
                    required,
                },
                number: {
                    required,
                },
                group_id: {
                    required,
                },
                course_id: {
                    required,
                },
                audience_id: {
                    required,
                },
            },
        },
        methods: {
            getValidationClass(fieldName) {
                const field = this.$v.form[fieldName];

                if (field) {
                    return {
                        'md-invalid': field.$invalid && field.$dirty,
                    };
                }
            },
            clearForm() {
                this.$v.$reset();
                this.form.day_of_week = null;
                this.form.number = null;
                this.form.is_first_semester = false;
                this.form.is_numerator = null;
                this.form.group_id = null;
                this.form.course_id = null;
                this.form.audience_id = null;
            },
            saveTimetable() {
                this.lastTimetable = `${this.courses.filter(course => course.id === this.form.course_id)[0].name}`;
                this.$store.dispatch('timetable/storeTimetable', { ...this.form });
            },
            validateTimetable() {
                this.$v.$touch();

                if (!this.$v.$invalid) {
                    this.saveTimetable();
                    this.clearForm();
                }
            },
        },
        computed: mapState({
            groups: state => state.timetable.groups,
            courses: state => state.timetable.courses,
            audiences: state => state.timetable.audiences,
            sending: state => state.timetable.status.sending,
            success: state => state.timetable.status.success,
            error: state => state.timetable.status.error,
        }),
        beforeCreate() {
            this.$store.dispatch('timetable/getGroups');
            this.$store.dispatch('timetable/getCourses');
            this.$store.dispatch('timetable/getAudiences');
        },
    };
</script>

<style lang="scss" scoped>
    .md-progress-bar {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
    }
</style>
