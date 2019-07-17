<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Calendar</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <form v-on:submit.prevent="formSubmit" method="post" action="">    

                                    <div class="form-group">
                                        <label for="myEvent">Event</label>
                                        <input type="text" class="form-control" id="myEvent" v-model="model.event_description" placeholder="">
                                    </div>
                                   
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="from">From</label>
                                            <date-picker :first-day-of-week="1" v-model="model.dates.dtStart" @input="setDatesRanges()" placeholder="From Date" lang="en" style="width:100%"></date-picker>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="to">To</label>
                                            <date-picker :first-day-of-week="1" v-model="model.dates.dtEnd" @input="setDatesRanges()" placeholder="From Date" lang="en" style="width:100%"></date-picker>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">  
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="Sun" value="Sun" v-model="model.day.Sun">
                                                <label class="form-check-label" for="Sun">Sun</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="Mon" value="Mon" v-model="model.day.Mon">
                                                <label class="form-check-label" for="Mon">Mon</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="Tue" value="Tue" v-model="model.day.Tue">
                                                <label class="form-check-label" for="Tue">Tue</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="Wed" value="Wed" v-model="model.day.Wed">
                                                <label class="form-check-label" for="Wed">Wed</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="Thu" value="Thu" v-model="model.day.Thu">
                                                <label class="form-check-label" for="Thu">Thu</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="Fri" value="Fri" v-model="model.day.Fri">
                                                <label class="form-check-label" for="Fri">Fri</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="Sat" value="Sat" v-model="model.day.Sat">
                                                <label class="form-check-label" for="Sat">Sat</label>
                                            </div>
                                        </div>
                                   </div>

                                    <div class="form-row">
                                        <button type="button" class="btn btn-outline btn-primary" data-dismiss="modal" aria-hidden="true" @click='save' :disabled="disableButt">SAVE</button> 
                                    </div>                                    

                                </form>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                <h2>{{ monthName }}</h2>
                                <div v-for="data in datesRange" class="w-100" style="border-bottom: 1px solid #c5c5c5">
                                    <div style="width:15%; float:left; line-height:40px" v-bind:class="{'gb-color': data['event_description']!='', 'gb-color-white': data['event_description']==''}">
                                        {{ data['day_number'] }} {{ data['event_day'] }}
                                    </div>
                                    <div style="width:85%; float:left; line-height:40px" v-bind:class="{'gb-color': data['event_description']!='', 'gb-color-white': data['event_description']==''}">
                                        {{ data['event_description'] }}
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { getMonthName, plotEvents, plotCalendar } from '../helpers/helper';
    import axios from "axios";
    import DatePicker from 'vue2-datepicker';
    export default {
        components: { DatePicker },
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                datesRange: [],
                disableButt: true,
                monthName: '',
                model: {
                    event_description:'',
                    event_date: '',
                    day: {
                        Sun:'',
                        Mon:'',
                        Tue:'',
                        Wed:'',
                        Thu:'',
                        Fri:'',
                        Sat:''
                    },
                    dates: { dtStart:'' , dtEnd:'' }
                },
            }
        },
        watch:{

        }, 
        created() {
            let d = new Date;
            this.monthName = getMonthName(d)+ " " +d.getFullYear();
        },
        methods: {
            setDatesRanges () {
                
                var start = new Date(this.model.dates.dtStart);
                var end = new Date(this.model.dates.dtEnd);
                if(start>=end && start!= null && end!= null)
                {
                    this.disableButt = true;
                    this.$toastr.warning('Invalid date range', 'Error', {timeOut: 1000});
                    return;
                }
                else
                    this.disableButt = false;

                this.monthName = getMonthName(start)+ " " +start.getFullYear();
                if(this.datesRange.length==0)
                    this.datesRange = plotCalendar(this.model.dates);
            },
            save () {
                var start = new Date(this.model.dates.dtStart);
                var end = new Date(this.model.dates.dtEnd);
                
                if(this.model.event_description=='' || start== null ||  end == null)
                {
                    this.disableButt = true;
                    this.$toastr.warning('All fields are required', 'Error', {timeOut: 1000});
                    return;
                }
                else
                    this.disableButt = false;

                var that = this

                this.model.dates.dtStart = (start.getMonth()+1)+"/"+start.getDate()+"/"+start.getFullYear();
                this.model.dates.dtEnd = (end.getMonth()+1)+"/"+end.getDate()+"/"+end.getFullYear();
                this.$http.post("/add_events",this.model).then(res=>{
                    if(res.data.status){
                        that.$toastr.success(res.data.mess, 'Success', {timeOut: 1000});
                        this.datesRange = plotEvents(res.data.events);
                        console.log(this.datesRange)
                    }else{
                        that.$toastr.error(res.data.mess, 'Error', {timeOut: 1000});
                    }
                    
                }).catch((err) => {
                        that.$toastr.error("Problem Encountered", 'Error', {timeOut: 1000});
                });    
            }      
        
        }
    }
</script>
<style scoped>
    .gb-color {
        background: #d5ffec;
    }
    .gb-color-white {
        background: #fff;
    }
</style>