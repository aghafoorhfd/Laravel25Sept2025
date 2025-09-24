"use strict";
var courseStudyApp =  new Vue({
    el:'#course_study_box',
    data:{
        course_id:course_data.id,
        sections:course_data.sections,
        currentModule:{},
        currentSection:{},
        routes:course_data.routes
    },
    created:function(){
    },
    methods:{
        selectModule(module,section){
            this.currentModule = module;
            this.currentSection = section;
        },
        toggleSection(section){
            if(section.active){
                section.active = true;
            }else{
                section.active = false;
            }
        },
        sendLog:function () {
            if(this.currentModule.completion_state) return;
            $.ajax({
                url:this.routes.log,
                data:{
                    course_id:this.course_id,
                    module_id:this.currentModule.id,
                    section_id:this.currentSection.id
                },
                method:'post',
                dataTye:'json'
            })
        }
    }
})
