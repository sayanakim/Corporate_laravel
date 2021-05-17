
@if (count($errors) > 0)
    <div class="box error-box">

        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach

    </div>
@endif

@if (session('status'))
    <div class="box success-box">
        {{ session('status') }}
    </div>
@endif

<div id="content-page" class="content group">
    <div class="hentry group">
        <form id="contact-form-contact-us" class="contact-form" method="post" action="{{ route('contacts') }}" enctype="multipart/form-data">
            <div class="usermessagea"></div>
            <fieldset>
                <ul>
                    <li class="text-field">
                        <label for="name-contact-us">
                            <span class="label">Name</span>
                            <br /><span class="sublabel">This is the name</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input type="text" name="name" id="name-contact-us" class="required" value="" /></div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="text-field">
                        <label for="email-contact-us">
                            <span class="label">Email</span>
                            <br /><span class="sublabel">This is a field email</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input type="text" name="email" id="email-contact-us" class="required email-validate" value="" /></div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="textarea-field">
                        <label for="message-contact-us">
                            <span class="label">Message</span>
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span><textarea name="text" id="message-contact-us" rows="8" cols="30" class="required"></textarea></div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="submit-button">
                        {{ csrf_field() }}
                        <input type="text" name="yit_bot" id="yit_bot" />

                        <input type="submit" name="yit_sendmail" value="Send Message" class="sendmail alignright" />
                    </li>
                </ul>
            </fieldset>
        </form>
        <script type="text/javascript">
            var messages_form_126 = {
                name: "Please, fill in your name",
                email: "Please, insert a valid email address",
                message: "Please, insert your message"
            };
        </script>
    </div>
    <!-- START COMMENTS -->
    <div id="comments">
    </div>
    <!-- END COMMENTS -->
</div>
