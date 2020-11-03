<template>
    <div class="row">
        <div class="col-8 d-flex flex-column p-4">
            <h2 class="p-4">Доступные для Вас группы: </h2>
            <span class="ital">(нажмите на нужную..)</span>
            <div class="group-title p-2" v-for="item in groups" @click="getPersonsByGroupId(item.id)">
                <span class="text-up">{{ item.title }}</span>
            </div>
            <div v-if="tableFlag==1">
                <table v-for="group in persons" class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Дата рождения</th>
                            <th scope="col">Наименование группы</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in group.persons">
                            <th scope="row">{{ item.id }}</th>
                            <td>{{ item.last_name }} {{ item.first_name }} {{ item.middle_name }}</td>
                            <td>{{ item.birth_date }}</td>
                            <td class="group-name red">{{ group.title }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="offset-1 col-3 mb-3">
            <br>
            <br>
            <br>
            <div class="mb-3">Введите id студента от {{ range.start }} до {{ range.end }}:</div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Id:</span>
                </div>
                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" v-model="ageCount">
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <button type="button" class="btn btn-success btn-lg btn-custom" @click="countAge(ageCount)">Тест</button>
            </div>
            <div class="mt-2" v-if="ageCount!=''">
                <span class="group-name">{{ agePersonData.firstName }} {{ agePersonData.lastName }}</span><br>
                Дата рождения: {{ agePersonData.birthDate }}<br>
                Полных лет: {{ agePersonData.age }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                is_refresh: true,
                groups: [],
                persons: [''],
                age: '',
                agePersonData: {
                    firstName: '',
                    lastName: '',
                    birthDate: '',
                    age: ''
                },
                ageCount: '',
                tableFlag: '',
                range: {
                    start: '',
                    end: ''
                }
            }
        },
        mounted() {
            // this.update();
            this.getGroups();
        },
        updated() {
            this.getRange();
        },
        methods: {
            getGroups: function() {
                this.is_refresh = true;
                this.places = [];
                axios.post('/api/groupslist').then((response) => {
                        this.groups = response.data;
                        this.is_refresh = false;
                    });
            },
            getPersonsByGroupId: function(groupid) {
                this.tableFlag = '';
                this.persons = [''];
                axios.get('/api/personsbygroupid?groupid='+ groupid).then((response) => {
                    this.persons = response.data;
                    console.log(this.persons);
                    this.tableFlag = 1;
                })
            },
            countAge: function(id) {
                this.age = '';
                if (this.ageCount != '') {
                    if ((this.ageCount >= this.range.start) && (this.ageCount <= this.range.end)) {
                        axios.post('/api/personbyid/'+ id).then((response) =>{
                            this.agePersonData.age = response.data[0]["age"];
                            this.agePersonData.firstName = response.data[0]["first_name"];
                            this.agePersonData.lastName = response.data[0]["last_name"];
                            this.agePersonData.birthDate = response.data[0]["birth_date"];
                        })
                    } else {
                        alert('Неправильное id пользователя...')
                    }
                } else {
                    alert('Введите id пользователя!')
                }
            },
            getRange: function() {
                axios.post('/api/getPersonsRange').then((response) => {
                    console.log(response.data);
                    this.range.start = response.data.start;
                    this.range.end = response.data.end;
                })
            }
        }
    }
</script>