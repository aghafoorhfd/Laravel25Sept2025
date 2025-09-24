<div class="panel">
    <div class="panel-title"><strong>{{__("Pricing")}}</strong></div>
    <div class="panel-body">
        <h3 class="panel-body-title">{{__("Course Price")}}</h3>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="control-label">{{__("Price")}}</label>
                    <input type="number" min="0" name="price" class="form-control" value="{{$row->price}}" placeholder="{{__("Course")}}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="control-label">{{__("Easypaisa Price")}}</label>
                    <input type="number" min="0" step="0.1" name="easypaisa_price" class="form-control" value="{{$row->easypaisa_price}}" placeholder="{{__("EasyPaisa Price")}}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="control-label">{{__("Sale Price")}}</label>
                    <input type="text" name="sale_price" class="form-control" value="{{$row->sale_price}}" placeholder="{{__("Course Sale Price")}}">
                </div>
            </div>
            <div class="col-lg-12">
                <span>
                    {{__("If the regular price is less than the discount , it will show the regular price")}}
                </span>
            </div>
        </div>
    </div>
</div>
