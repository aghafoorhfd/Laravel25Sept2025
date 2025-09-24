<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">

        <div id="lecture_management" v-cloak>
            <div class="d-flex justify-content-end mb-4">
                <button @click="openSectionForm" class="btn btn-warning btn-sm" type="button">
                    <i class="fa fa-plus"></i> {{__("Add Section")}}
                </button>
            </div>
            <div class="panel" v-for="row in sections">
                <div class="panel-title d-flex justify-content-between">
                    <div class="flex-left">
                        <i :class="{'text-success':row.active == 1,'text-danger':row.active == 0}" class=" fa fa-circle"></i>
                        <strong>@{{ row.name }} </strong>
                        <i class="fa fa-edit edit-section" @click="openSectionForm($event,row)"></i>
                    </div>
                    <div class="flex-right">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-plus"></i> {{__("Add lecture")}}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a href="#" class="dropdown-item" @click.prevent="addLesson('video',row)"><i class="fa fa-play-circle-o"></i> {{__("Add video")}}</a>
                                <a href="#" class="dropdown-item" @click.prevent="addLesson('presentation',row)"><i class="fa fa-file-powerpoint-o"></i> {{__("Add presentation")}}</a>
                                <a href="#" class="dropdown-item" @click.prevent="addLesson('iframe',row)"><i class="fa fa-desktop"></i> {{__("Add Iframe")}}</a>
                                <a href="#" class="dropdown-item" @click.prevent="addLesson('scorm',row)"><i class="fa fa-bookmark"></i> {{__("Add SCORM")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group-item">
                        <div class="g-items-header">
                            <div class="row">
                                <div class="col-md-5">{{__("Title")}}</div>
                                <div class="col-md-2">{{__("Type")}}</div>
                                <div class="col-md-2">{{__("Duration")}}</div>
                                <div class="col-md-1">{{__("Order")}}</div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                        <div class="g-items">
                            <div class="item" v-for="module in row.lessons">
                                <div class="row">
                                    <div class="col-md-5">
                                        <i :class="{'text-success':module.active == 1,'text-danger':module.active == 0}" class=" fa fa-circle"></i>
                                        @{{module.name}}</div>
                                    <div class="col-md-2">@{{module.type}}</div>
                                    <div class="col-md-2">@{{module.duration}}</div>
                                    <div class="col-md-1">@{{module.display_order}}</div>
                                    <div class="col-md-2">
                                        <span class="btn btn-warning btn-sm" @click="editLesson(module,row)"><i class="fa fa-pencil"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button @click="openSectionForm" class="btn btn-warning btn-sm" type="button">
                    <i class="fa fa-plus"></i> {{__("Add Section")}}
                </button>
            </div>

            <div id="add_lecture_modal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <span v-if="!lecture_form.id">@{{ add_lecture_title }}</span>
                                <span v-else>{{__("Edit Lesson")}}</span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{__("Lesson name")}} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" v-model="lecture_form.name">
                            </div>
                            <div class="form-group" v-if="['iframe'].indexOf(lecture_form.type) < 0">
                                <label>{{__("File")}} </label>
                                <file-picker :type="lecture_form.type" v-model="lecture_form.file_id"></file-picker>
                            </div>
                            <div class="form-group" v-if="['iframe'].indexOf(lecture_form.downloadable) < 0">
                                <label>{{__("Downloadable Resource")}} </label>
                                <file-picker :type="'presentation'" v-model="lecture_form.downloadable"></file-picker>
                            </div>
                            <div class="form-group" >
                                <label>{{__("File URL")}}</label>
                                <input type="text"  class="form-control" v-model="lecture_form.url">
                            </div>
                            <div class="form-group">
                                <label>{{__("Duration (minute)")}} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" placeholder="{{__("in minutes")}}" v-model="lecture_form.duration">
                            </div>
                            <div class="form-group" >
                                <label>{{__("Preview Url")}}</label>
                                <input type="text"  class="form-control" v-model="lecture_form.preview_url">
                            </div>
                            <div class="form-group" >
                                <label>{{__("Status")}}</label>
                                <select v-model="lecture_form.active" class="form-control">
                                    <option value="1">{{__("Active")}}</option>
                                    <option value="0">{{__("Inactive")}}</option>
                                </select>
                            </div>
                            <div class="form-group" >
                                <label>{{__("Display Order")}}</label>
                                <input type="number" min="0" step="1" v-model="lecture_form.display_order" class="form-control">
                            </div>
                            <div class="alert alert-danger" v-if="error.length" v-html="error.join('<br>')"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                            <button type="button" class="btn btn-primary" @click="saveLesson">{{__("Save changes")}}
                                <i class="fa-spin fa fa-spinner icon-loading" v-show="onSaving"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="add_section_modal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <span v-if="!section_form.id">{{ __("Add Section") }}</span>
                                <span v-else>{{__("Edit Section")}}</span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{__("Section name")}} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" v-model="section_form.name">
                            </div>
                            <div class="form-group" >
                                <label>{{__("Status")}}</label>
                                <select v-model="section_form.active" class="form-control">
                                    <option value="1">{{__("Active")}}</option>
                                    <option value="0">{{__("Inactive")}}</option>
                                </select>
                            </div>
                            <div class="form-group" >
                                <label>{{__("Display Order")}}</label>
                                <input type="number" min="0" step="1" v-model="section_form.display_order" class="form-control">
                            </div>
                            <div class="alert alert-danger" v-if="error.length" v-html="error.join('<br>')"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                            <button type="button" class="btn btn-primary" @click="saveSection">{{__("Save changes")}}
                                <i class="fa-spin fa fa-spinner icon-loading" v-show="onSaving"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    var course_sections_data = {!! json_encode($row->admin_js_data) !!};
</script>
