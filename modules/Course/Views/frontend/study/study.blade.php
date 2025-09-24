<div class="embed-video responsive-wrap" v-if="currentModule.study_url">
    <iframe class="responsive-iframe" v-if="currentModule" :src="currentModule.study_url" allowfullscreen frameborder="0"></iframe>
</div>
<div class="p-lg-5 p-3">
    <h2><a href="{{$row->getDetailUrl()}}">{{$translation->title}}</a></h2>
    <hr class="my-2">
    <h4 class="mt-4"> {{__('Description')}}</h4>
    <div class="course-content-html">
        {!! clean($translation->content) !!}
    </div>
</div>
