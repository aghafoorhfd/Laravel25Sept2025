import Vue from 'vue';
import file_picker from "../../../admin/js/components/file-picker"
export default function() {
    window.courseLecturesManagement = new Vue({
        el:'#lecture_management',
        data:{
            onEdit:false,
            options:{},
            sections:course_sections_data.sections,
            lecture_form:{
                type:'',
                id:'',
                name:'',
                duration:'',
                url:'',
                preview_url:'',
                file_id:'',
                active:1,
                display_order:0,
                downloadable:''
            },
            section_form:{
                id:'',
                name:'',
                active:1,
                display_order:0
            },
            i18n:course_sections_data.i18n,
            error:[],
            routes:course_sections_data.routes,
            onSaving:false,
            lastSection:false,
            course_id:course_sections_data.id,
            lastEditObject:{}
        },
        mounted:function () {
        },
        computed:{
            fileIdType:function () {
                switch (this.lecture_form.type) {
                    default:
                        return this.lecture_form.type;
                    break;
                }
            },
            add_lecture_title:function () {
                return this.i18n.add_lecture[this.lecture_form.type]
            },
        },
        methods:{
            addLesson:function (type,section) {
                this.lecture_form = {
                    type:type,
                    id:'',
                    name:'',
                    duration:'',
                    url:'',
                    preview_url:'',
                    file_id:'',
                    active:1,
                    display_order:0,
                    downloadable:''
                };
                this.lastSection = section;
                this.error = [];
                switch (type) {
                    default:
                        $('#add_lecture_modal').modal('show');
                        break;
                }

            },
            editLesson:function (row,section) {
                this.lastSection = section;
                this.lecture_form = Object.assign({},row);
                this.lastEditObject = row;
                this.error = [];

                $('#add_lecture_modal').modal('show');

            },
            openSectionForm:function (e,section) {
                this.error = [];
                if(section){
                    this.section_form = Object.assign({},section);
                    this.lastSection = section;
                }else{
                    this.section_form = {
                        id:'',
                        name:'',
                        active:1,
                        display_order:0
                    };
                }
                $('#add_section_modal').modal('show');

            },
            saveLesson:function () {
                var me = this;
                if(me.onSaving) return;

                if(!this.validateLecture()){
                    return false;
                }

                me.onSaving = true;

                var data = Object.assign({},this.lecture_form);
                data.section_id = me.lastSection ? me.lastSection.id : '';
                data.course_id = me.course_id;
                console.log(data)
                console.log(this.routes.store)
                $.ajax({
                    url:this.routes.store,
                    data:data,
                    dataType:'json',
                    type:'post',
                    success:function (json) {
                        me.onSaving = false;
                        if(json.message){
                            bookingCoreApp.showAjaxMessage(json);
                        }
                        if(json.lecture){
                            if(typeof me.lastSection.lessons == 'undefined'){
                                me.lastSection.lessons = [];
                            }
                            me.lastSection.lessons.push(json.lecture);
                        }else{
                            if(me.lastEditObject){
                                me.lastEditObject = data;
                            }
                            me.updateLectureData(data.section_id,data.id,data);

                        }
                        if(json.status){
                            $('#add_lecture_modal').modal('hide');
                        }

                    },
                    error:function (e) {
                        me.onSaving = false;
                        bookingCoreApp.showAjaxError(e);
                    }
                })
            },
            updateLectureData:function(section_id,lecture_id,data){
                var sectionIndex  = _.findIndex(this.sections,{id:section_id});
                if(sectionIndex > -1){
                    var lectureIndex = _.findIndex(this.sections[sectionIndex].lessons,{id:lecture_id});
                    if(lectureIndex > -1 ){
                        for(var k in data){
                            this.$set(this.sections[sectionIndex].lessons[lectureIndex],k,data[k]);
                        }
                    }
                }
            },
            validateLecture:function () {
                this.error = [];
                var error = [];
                if(!this.lecture_form.name){
                    error.push(this.i18n.validate.name);
                }
                if(!this.lecture_form.duration){
                    error.push(this.i18n.validate.duration);
                }
                this.error = error;
                if(error.length) return false;

                return true;
            },
            saveSection:function () {
                var me = this;
                if(me.onSaving) return;

                if(!this.validateSection()){
                    return false;
                }

                me.onSaving = true;

                var data = Object.assign({},this.section_form);
                data.course_id = me.course_id;
                $.ajax({
                    url:this.routes.store_section,
                    data:data,
                    dataType:'json',
                    type:'post',
                    success:function (json) {
                        me.onSaving = false;
                        if(json.message){
                            bookingCoreApp.showAjaxMessage(json);
                        }

                        if(json.section){
                            me.sections.push(json.section);
                        }else{
                            for(var k in data){
                                me.$set(me.lastSection,k,data[k]);
                            }
                        }

                        if(json.status){
                            $('#add_lecture_modal').modal('hide');
                        }
                    },
                    error:function (e) {
                        me.onSaving = false;
                        bookingCoreApp.showAjaxError(e);
                    }
                })
            },
            validateSection:function () {
                this.error = [];
                var error = [];
                if(!this.section_form.name){
                    error.push(this.i18n.validate.section_title);
                }
                this.error = error;
                if(error.length) return false;
                return true;
            },
        },
        components:{
            filePicker:file_picker
        }
    });
}
