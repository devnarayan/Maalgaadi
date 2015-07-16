            <tr>
                                            <td valign="top" width="20%"><label>Contact Phone number</label><span class="star">*</span></td>   
                                            <td><div class="new_input_field" style="width:400px;"><input type="text" name="phone_number" id="phone_number" title="Enter your phone number" maxlength="30" value="(972) 362-1153"></div>
                                                <span class="error"></span></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="20%"><label>Pagination Settings</label><span class="star">*</span></td>   
                                            <td>
                                                <div class="formRight">
                                                    <div class="selector" id="uniform-user_type">
                                                        <select name="pagination_settings" id="pagination_settings" title="Select the No of recards per page">
                                                            <option value="">-- Select --</option>
                                                            <option value="10">10</option>
                                                            <option value="20" selected="selected">20</option>
                                                            <option value="30">30</option>
                                                            <option value="40">40</option>
                                                            <option value="50">50</option>
                                                          </select>
                                                    </div>
                                                    <span class="error"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="20%"><label>Notification time</label><span class="star">*</span></td>   
                                            <td>
                                                <div class="new_input_field" style="width:400px;">
                                                    <input type="text" name="notification_settings" class="required chk onlynumbers" id="notification_settings" title="Enter notification time" maxlength="3" value="15"></div>
                                                <span class="error"></span>
                                                <span class="textclass fl clr">Driver Request Notification will expired with in Mentioned Sec(Add only for Seconds)</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="20%"><label>Tell To Friend Message</label><span class="star">*</span></td>   
                                            <td><div class="new_input_field" style="width:400px;"><textarea rows="5" cols="35" style="resize:none;" name="tell_to_friend_message" id="tell_to_friend_message" title="Enter tell to friend message" maxlength="150">Limo app,Savvy Ridei, mobile app for taxi,  app solution, taxi app developers, mobile app taxi, taxi mobile app</textarea></div>
                                                <span class="error"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="20%"><label>Meta Keywords</label><span class="star">*</span></td>   
                                            <td><div class="new_input_field" style="width:400px;">
                                                    <textarea name="meta_keyword" id="meta_keyword" rows="7" cols="35" title="Enter the meta keywords" style="resize:none;">Taxi app, tag my taxi, mobile app for taxi, taxi app solution, taxi app developers, mobile app taxi, taxi mobile app</textarea>
                                                </div>
                                                <span class="error"></span></td>
                                        </tr>

                                        <tr>
                                            <td valign="top" width="20%"><label>Meta Description</label><span class="star">*</span></td>   
                                            <td><div class="new_input_field" style="width:400px;">
                                                    <textarea name="meta_description" id="meta_description" rows="7" cols="35" title="Enter the meta description" style="resize:none;">Start your own taxi booking service like Uber. A complete solution to manage companies, taxies and drivers under one roof.</textarea>
                                                </div>
                                                <span class="error"></span></td>
                                        </tr>

                                        <tr>
                                            <td valign="top" width="20%"><label>SMS Enable</label><span class="star">*</span></td>   
                                            <td><div class="new_input_field">
                                                    <div class="formRight">
                                                        <div class="selector" id="uniform-user_type">
                                                            <select name="sms_enable" id="sms_enable" title="SMS Enable">
                                                                <option value="">-- Select --</option>
                                                                <option value="1" selected="selected">Yes</option>
                                                                <option value="0">No</option>
                                                                1</select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="error"></span></td>
                                        </tr>

                                        <tr>
                                            <td valign="top" width="20%"><label>Fare Settings</label><span class="star">*</span></td>        
                                            <td>
                                                <div class="formRight">
                                                    <div id="uniform-user_type">
                                                        <div id="fare_settings">
                                                            <input type="radio" name="price_settings" value="1" checked="checked"> Admin Fare			<input type="radio" name="price_settings" value="2"> Company Fare		</div>	
                                                    </div>
                                                </div>
                                                <label for="fare_settings" generated="true" style="display:none" class="errorvalid">Select Fare Settings</label>	
                                            </td>   	
                                        </tr>
                                        <tr>
                                            <td valign="top" width="20%"><label>Currency Code</label><span class="star">*</span></td>        
                                            <td>
                                                <div class="formRight">
                                                    <div class="selector" id="uniform-user_type">
                                                        <span>Currency Code</span>
                                                        <div id="currency_code">
                                                            <select name="currency_code" id="currency_code" class="required" title="select_currency_code">
                                                                <option value="">-- Select Currency Code--</option>
                                                                <option value="USD" selected="selected">USD</option>
                                                                <option value="GE">GE</option>
                                                                <option value="CNY">CNY</option>
                                                                <option value="25">25</option>
                                                                <option value="SGD">SGD</option>
                                                                <option value="mxn">mxn</option>
                                                                <option value="MA">MA</option>
                                                                <option value="Rials">Rials</option>
                                                                <option value="CAD">CAD</option>

                                                            </select>
                                                        </div>	
                                                    </div>
                                                </div>
                                                <label for="currency_code" generated="true" style="display:none" class="errorvalid">select_currency_code</label>	
                                            </td>   	
                                        </tr>
                                        <tr>
                                            <td valign="top" width="20%"><label>Currency Symbol</label><span class="star">*</span></td>   
                                            <td><div class="new_input_field">
                                                    <div class="formRight">
                                                        <div class="selector" id="uniform-user_type">
                                                            <select name="site_currency" id="site_currency" title="enter_site_currency">
                                                                <option value="">-- Select Currency --</option>
                                                                <option value="$" selected="selected">$</option>
                                                                <option value="€">€</option>
                                                                <option value="#">#</option>
                                                                <option value="MAD">MAD</option>
                                                                <option value="Rls">Rls</option>
                                                                $</select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="error"></span></td>
                                        </tr>

                                        <tr>
                                            <td valign="top" width="20%"><label>Show map</label><span class="star">*</span></td>   
                                            <td><div class="new_input_field">
                                                    <div class="formRight">
                                                        <div class="selector" id="uniform-user_type">
                                                            <select name="show_map" id="show_map" title="Select where to show map">
                                                                <option value="">-- Select --</option>
                                                                <option value="1">Front End</option>
                                                                <option value="2">Admin End</option>
                                                                <option value="3" selected="selected">Both Front &amp; Back End</option>
                                                                3						</select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="error"></span></td>
                                        </tr>

                                        <tr>
                                            <td valign="top" width="20%"><label>Admin Commission</label><span class="star">*</span></td>   
                                            <td><div class="new_input_field" style="width:400px;">
                                                    <input type="text" name="admin_commission" id="admin_commission" title="Enter the admin commission" maxlength="4" value="20">
                                                </div>
                                                <span class="error"></span>
                                                <span class="textclass fl clr">Update the admin commission in percentage. Ex:10</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="20%"><label>Taxi Charge ($)</label><span class="star">*</span></td>   
                                            <td><div class="new_input_field" style="width:400px;">
                                                    <input type="text" name="taxi_charge" id="taxi_charge" title="Enter the Taxi Charge" maxlength="6" value="0">
                                                </div>
                                                <span class="error"></span>
                                            </td>
                                        </tr>                    
                                    <input type="hidden" name="min_fund" id="min_fund" title="Enter min fund request" maxlength="5" value="2">
                                    <input type="hidden" name="max_fund" id="max_fund" title="The maximum fund request should not be less than minimum fund request" maxlength="5" value="52">
                                    <tr>
                                        <td valign="top" width="20%"><label>Copyrights Info</label><span class="star">*</span></td>   
                                        <td>
                                            <div class="new_input_field" style="width:400px;">
                                                <input type="text" name="site_copyrights" id="site_copyrights" title="Enter copyrights info" maxlength="100" value="©2014 Tagmytaxi. All rights reserved.">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Site Logo</label><span class="star">*</span></td>   
                                        <td>
                                            <div class="new_input_field">
                                                <input type="file" name="site_logo" id="site_logo" class="imageonly" title="Please upload image (jpg, jpeg, png)" value="logo">

                                            </div>
                                            <div class="site_logo" style="width:160px;">
                                                <img src="http://demo.tagmytaxi.com/public/admin/images//logo.png" width="160">
                                            </div>
                                            <span>Upload image (jpg, jpeg, png) and size must be with in 128 x 25</span>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="20%"><label>Site Email Logo</label><span class="star">*</span></td>   
                                        <td>
                                            <div class="new_input_field">
                                                <input type="file" name="email_site_logo" id="email_site_logo" class="imageonly" title="Please upload image (jpg, jpeg, png)" value="email_site_logo.png">
                                            </div>
                                            <div class="email_site_logo" style="width:160px;">
                                                <img src="http://demo.tagmytaxi.com/public/uploads/site_logo/email_site_logo.png" width="160">
                                            </div>
                                            <span>Upload image (jpg, jpeg, png) and size must be with in 175 x 35</span>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td valign="top" width="20%"><label>Site favicon image</label><span class="star">*</span></td>   
                                        <td>
                                            <div class="new_input_field">
                                                <input type="file" name="site_favicon" id="site_favicon" class="imageonly" title="Please upload image (jpg, jpeg, png)" value="5319a6200b16434b31b13f04.png">

                                            </div>
                                            <div class="site_logo" style="width:220px;"> <input type="hidden" name="favicon_old" id="favicon_old" value="5319a6200b16434b31b13f04.png">
                                                <img src="http://demo.tagmytaxi.com/public/uploads/favicon/5319a6200b16434b31b13f04.png">
                                            </div>
                                            <span>Upload image (jpg, jpeg, png) and size must be with in 64 x 64</span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="" class="star">*Required Fields</td>
                                    </tr>    