<ol class=" list-paddingleft-2" style="list-style-type: decimal;">
    <li>
        <h3 style="text-indent: 0em;">
            文件锁定机制<br/>
        </h3>
    </li>
</ol>
<p>
    文件系统操作是在网络环境下完成的，可能有多个用户同一时刻对服务器上的同一个文件访问。当这种访问出现时，很可能破坏文件中的数据。
</p>
<p>
    在php中提供了flock函数，可以对文件使用锁定机制（锁定或释放文件）。当一个进程在访问文件时加上锁，其他进程如果想对文件进行访问，则必须等到锁定被释放之后。这样就可以避免在并发访问同一个数据文件内容被破坏。
</p>
<p>
    函数原型：
</p>
<pre class="brush:php;toolbar:false">bool flock ( resource $handle , int $operation [, int &amp;$wouldblock ] )</pre>
<ul class=" list-paddingleft-2">
    <li style="">
        <p>
            <code class="parameter" style="font-weight: 700; font-stretch: normal; font-size: 1rem; line-height: 1.375rem; font-family: &quot;Fira Mono&quot;, &quot;Source Code Pro&quot;, monospace; word-wrap: break-word; color: rgb(51, 102, 153); cursor: pointer;">handle</code>
        </p>
    </li>
    <li style="">
        <p class="para" style="margin-top: 0px; margin-bottom: 1.5rem;">
            文件系统指针，是典型地由&nbsp;<span class="function"><a href="http://php.net/manual/zh/function.fopen.php" class="function" style="border-bottom: 1px solid; text-decoration: none; color: rgb(51, 102, 153);">fopen()</a></span>&nbsp;创建的&nbsp;<span class="type"><a href="http://php.net/manual/zh/language.types.resource.php" class="type resource" style="border-bottom: 1px solid; text-decoration: none; color: rgb(51, 102, 153);">resource</a></span>(资源)。
        </p>
    </li>
    <li style="">
        <p>
            <code class="parameter" style="font-weight: 700; font-stretch: normal; font-size: 1rem; line-height: 1.375rem; font-family: &quot;Fira Mono&quot;, &quot;Source Code Pro&quot;, monospace; word-wrap: break-word; color: rgb(51, 102, 153); cursor: pointer;">operation</code>
        </p>
    </li>
    <li style="">
        <p class="para" style="margin-top: 0px; margin-bottom: 1.5rem;">
            <code class="parameter" style="font-weight: 700; font-stretch: normal; font-size: 1rem; line-height: 1.375rem; font-family: &quot;Fira Mono&quot;, &quot;Source Code Pro&quot;, monospace; word-wrap: break-word; color: rgb(51, 102, 153); cursor: pointer;">operation</code>&nbsp;可以是以下值之一：
        </p>
        <ul class="itemizedlist list-paddingleft-2" style="list-style-type: circle;">
            <li>
                <p>
                    <span class="simpara"><span style="text-rendering: optimizeLegibility;"><code style="font-weight: 700; font-stretch: normal; font-size: 0.875rem; line-height: 1.375rem; font-family: &quot;Fira Mono&quot;, &quot;Source Code Pro&quot;, monospace; word-wrap: break-word;">LOCK_SH</code></span>取得共享锁定（读取的程序）。</span>
                </p>
            </li>
            <li>
                <p>
                    <span class="simpara"><span style="text-rendering: optimizeLegibility;"><code style="font-weight: 700; font-stretch: normal; font-size: 0.875rem; line-height: 1.375rem; font-family: &quot;Fira Mono&quot;, &quot;Source Code Pro&quot;, monospace; word-wrap: break-word;">LOCK_EX</code></span>&nbsp;取得独占锁定（写入的程序。</span>
                </p>
            </li>
            <li>
                <p>
                    <span class="simpara"><span style="text-rendering: optimizeLegibility;"><code style="font-weight: 700; font-stretch: normal; font-size: 0.875rem; line-height: 1.375rem; font-family: &quot;Fira Mono&quot;, &quot;Source Code Pro&quot;, monospace; word-wrap: break-word;">LOCK_UN</code></span>&nbsp;释放锁定（无论共享或独占）。</span>
                </p>
            </li>
        </ul>
        <p class="para" style="margin-top: 0px; margin-bottom: 1.5rem;">
            如果不希望&nbsp;<span class="function"><span style="text-rendering: optimizeLegibility;">flock()</span></span>&nbsp;在锁定时堵塞，则是&nbsp;<span style="text-rendering: optimizeLegibility;"><code style="font-weight: 700; font-stretch: normal; font-size: 0.875rem; line-height: 1.375rem; font-family: &quot;Fira Mono&quot;, &quot;Source Code Pro&quot;, monospace; word-wrap: break-word;">LOCK_NB</code></span>（Windows 上还不支持）。
        </p>
    </li>
    <li style="">
        <p>
            <code class="parameter" style="font-weight: 700; font-stretch: normal; font-size: 1rem; line-height: 1.375rem; font-family: &quot;Fira Mono&quot;, &quot;Source Code Pro&quot;, monospace; word-wrap: break-word; color: rgb(51, 102, 153); cursor: pointer;">wouldblock</code>
        </p>
    </li>
    <li style="">
        <p class="para" style="margin-top: 0px; margin-bottom: 1.5rem;">
            如果锁定会堵塞的话（EWOULDBLOCK 错误码情况下），可选的第三个参数会被设置为&nbsp;<span style="text-rendering: optimizeLegibility;"><code style="font-weight: 700; font-stretch: normal; font-size: 0.875rem; line-height: 1.375rem; font-family: &quot;Fira Mono&quot;, &quot;Source Code Pro&quot;, monospace; word-wrap: break-word;">TRUE</code></span>。（Windows 上不支持）
        </p>
    </li>
</ul>
<p>
    <br/>
</p>