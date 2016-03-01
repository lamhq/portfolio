<style type="text/css">
.code span {
  font-family: 'Consolas';
  font-size: 12pt;
  color: #C0C0C0;
}
.code .sc0 {
  color: #E08056;
}
.code .sc5 {
  color: #E08056;
}
.code .sc7 {
  color: #CEDAE3;
}
.code .sc10 {
  color: #C6752D;
}
.code .sc11 {
  color: #DFC47D;
}

</style>
<div class="code" style="float: left; white-space: pre; line-height: 1; background: #1D1D1D; "><span class="sc10">(</span><span class="sc5">function</span><span class="sc0"> </span><span class="sc10">(</span><span class="sc11">$</span><span class="sc10">)</span><span class="sc0"> </span><span class="sc10">{</span><span class="sc0">
    </span><span class="sc5">var</span><span class="sc0"> </span><span class="sc11">objs</span><span class="sc0"> </span><span class="sc10">=</span><span class="sc0"> </span><span class="sc10">[];</span><span class="sc0">
    </span><span class="sc11">$</span><span class="sc10">(</span><span class="sc7">'.bid'</span><span class="sc10">).</span><span class="sc11">each</span><span class="sc10">(</span><span class="sc5">function</span><span class="sc0"> </span><span class="sc10">()</span><span class="sc0"> </span><span class="sc10">{</span><span class="sc0">
        </span><span class="sc5">var</span><span class="sc0"> </span><span class="sc11">usn</span><span class="sc0"> </span><span class="sc10">=</span><span class="sc0"> </span><span class="sc11">$</span><span class="sc10">(</span><span class="sc5">this</span><span class="sc10">).</span><span class="sc11">find</span><span class="sc10">(</span><span class="sc7">'.lnk-username .bold'</span><span class="sc10">).</span><span class="sc11">text</span><span class="sc10">();</span><span class="sc0">
        </span><span class="sc5">var</span><span class="sc0"> </span><span class="sc11">rating</span><span class="sc0"> </span><span class="sc10">=</span><span class="sc0"> </span><span class="sc11">$</span><span class="sc10">(</span><span class="sc5">this</span><span class="sc10">).</span><span class="sc11">find</span><span class="sc10">(</span><span class="sc7">'.user-rating'</span><span class="sc10">).</span><span class="sc11">attr</span><span class="sc10">(</span><span class="sc7">'data-star_rating'</span><span class="sc10">);</span><span class="sc0">
        </span><span class="sc5">var</span><span class="sc0"> </span><span class="sc11">price</span><span class="sc0"> </span><span class="sc10">=</span><span class="sc0"> </span><span class="sc11">$</span><span class="sc10">(</span><span class="sc5">this</span><span class="sc10">).</span><span class="sc11">find</span><span class="sc10">(</span><span class="sc7">'.actual-amount'</span><span class="sc10">).</span><span class="sc11">text</span><span class="sc10">();</span><span class="sc0">
        </span><span class="sc5">var</span><span class="sc0"> </span><span class="sc11">period</span><span class="sc0"> </span><span class="sc10">=</span><span class="sc0"> </span><span class="sc11">$</span><span class="sc10">(</span><span class="sc5">this</span><span class="sc10">).</span><span class="sc11">find</span><span class="sc10">(</span><span class="sc7">'.actual-period'</span><span class="sc10">).</span><span class="sc11">text</span><span class="sc10">().</span><span class="sc11">replace</span><span class="sc10">(</span><span class="sc7">'in '</span><span class="sc10">,</span><span class="sc0"> </span><span class="sc7">''</span><span class="sc10">).</span><span class="sc11">replace</span><span class="sc10">(</span><span class="sc7">' days'</span><span class="sc10">,</span><span class="sc0"> </span><span class="sc7">''</span><span class="sc10">).</span><span class="sc11">replace</span><span class="sc10">(</span><span class="sc7">' day'</span><span class="sc10">,</span><span class="sc0"> </span><span class="sc7">''</span><span class="sc10">);</span><span class="sc0">
        </span><span class="sc5">var</span><span class="sc0"> </span><span class="sc11">fr</span><span class="sc0"> </span><span class="sc10">=</span><span class="sc0"> </span><span class="sc10">{</span><span class="sc0">
            </span><span class="sc7">'name'</span><span class="sc0"> </span><span class="sc10">:</span><span class="sc0"> </span><span class="sc11">usn</span><span class="sc10">,</span><span class="sc0">
            </span><span class="sc7">'rating'</span><span class="sc0"> </span><span class="sc10">:</span><span class="sc0"> </span><span class="sc11">rating</span><span class="sc10">,</span><span class="sc0">
            </span><span class="sc7">'price'</span><span class="sc10">:</span><span class="sc0"> </span><span class="sc11">price</span><span class="sc10">,</span><span class="sc0">
            </span><span class="sc7">'period'</span><span class="sc10">:</span><span class="sc0"> </span><span class="sc11">period</span><span class="sc0">
        </span><span class="sc10">}</span><span class="sc0">
        </span><span class="sc11">objs</span><span class="sc10">.</span><span class="sc11">push</span><span class="sc10">(</span><span class="sc11">fr</span><span class="sc10">);</span><span class="sc0">
    </span><span class="sc10">});</span><span class="sc0">
    </span><span class="sc5">var</span><span class="sc0"> </span><span class="sc11">e</span><span class="sc0"> </span><span class="sc10">=</span><span class="sc0"> </span><span class="sc11">$</span><span class="sc10">(</span><span class="sc7">'&lt;textarea&gt;&lt;/textarea&gt;'</span><span class="sc10">);</span><span class="sc0">
    </span><span class="sc11">e</span><span class="sc10">.</span><span class="sc11">text</span><span class="sc10">(</span><span class="sc11">JSON</span><span class="sc10">.</span><span class="sc11">stringify</span><span class="sc10">(</span><span class="sc11">objs</span><span class="sc10">));</span><span class="sc0">
    </span><span class="sc11">$</span><span class="sc10">(</span><span class="sc7">'#projectViewContainer'</span><span class="sc10">).</span><span class="sc11">prepend</span><span class="sc10">(</span><span class="sc11">e</span><span class="sc10">);</span><span class="sc0">
</span><span class="sc10">})(</span><span class="sc11">jQuery</span><span class="sc10">);</span></div>