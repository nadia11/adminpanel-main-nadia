<div class="modal fade" id="editNewsModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update News</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('edit-news-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="news_title" class="control-label">News Title</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="news_title" id="news_title" class="form-control" placeholder="News Title" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="news_body" class="control-label">News Body</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="news_body" id="news_body" class="form-control" cols="30" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="news_status" class="control-label">Status</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-th-large"></i></div>
                            </div>
                            <select id="news_status" name="news_status" class="custom-select" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category_id" class="control-label">Category</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-th-large"></i></div>
                            </div>
                            <select id="category_id" name="category_id" class="custom-select">
                                <option value="" selected="selected">--Category--</option>
                                @php $news_categories = DB::table('news_categories')->orderBy('category_name', 'ASC')->pluck("category_name", "category_id") @endphp

                                @foreach( $news_categories as $key => $news_category )
                                    <option value="{{ $key }}">{{ $news_category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="news_picture" class="control-label">News Picture</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="news_picture" id="news_picture" class="custom-file-input" accept=".png, .jpg, .jpeg" required />
                                <label class="custom-file-label" for="news_picture">Choose News Picture</label>
                            </div>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="news_id" value="" />
                    <input type="hidden" name="news_picture_prev" id="news_picture_prev">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark"><i class="fa fa-plus" aria-hidden="true"></i> Update</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
