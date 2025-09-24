<!-- sidebar -->
<div class="vidlist-3-container">
    <h5 class="course-name">{{$translation->title}}</h5>
    <ul class="vidlist-3-section">
        <li :class="{'open':section.active}" v-for="(section,section_index) in sections">
            <a class="accordion-title" href="#" @click.prevent="section.active = !section.active">@{{ section.title }}
                <i class="fa fa-angle-down" v-if="!section.active"></i>
                <i class="fa fa-angle-up" v-else=""></i>
            </a>
            <div class="accordion-content" v-show="section.active">
                <!-- vidlist -->
                <ul class="vidlist-3" >
                    <li v-for="module in section.lessons" :class="{'active':module.id == currentModule.id}"> <a @click="selectModule(module,section)"  href="#"> @{{module.title}}

                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
