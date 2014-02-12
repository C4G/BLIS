  


<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# githubog: http://ogp.me/ns/fb/githubog#">
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ColumnFilterWidgets/media/js/ColumnFilterWidgets.js at master · cyberhobo/ColumnFilterWidgets · GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub" />
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="apple-touch-icon-114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch-icon-114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon-144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144.png" />

    
    
    <link rel="icon" type="image/x-icon" href="/favicon.png" />

    <meta content="authenticity_token" name="csrf-param" />
<meta content="cJaQnDxlBXNgvTk291RHFFTgHlRzfDpQi5eNqaPnwZ4=" name="csrf-token" />

    <link href="https://a248.e.akamai.net/assets.github.com/assets/github-f48ab470494e437a201e317d865b504dcbe92f4d.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="https://a248.e.akamai.net/assets.github.com/assets/github2-2e78245e93eb414e33b3c1177b8ccfc708fbd023.css" media="screen" rel="stylesheet" type="text/css" />
    


    <script src="https://a248.e.akamai.net/assets.github.com/assets/frameworks-6f842b2765e7d98b7e93cadc2a364b831cfae37e.js" type="text/javascript"></script>
    
    <script defer="defer" src="https://a248.e.akamai.net/assets.github.com/assets/github-5589b022e6374ae9718c83a46cc31d453a4fa243.js" type="text/javascript"></script>
    
    

      <link rel='permalink' href='/cyberhobo/ColumnFilterWidgets/blob/c1bb020583ac0fccf04425cbaa7713b6070aa6ca/media/js/ColumnFilterWidgets.js'>
    <meta property="og:title" content="ColumnFilterWidgets"/>
    <meta property="og:type" content="githubog:gitrepository"/>
    <meta property="og:url" content="https://github.com/cyberhobo/ColumnFilterWidgets"/>
    <meta property="og:image" content="https://a248.e.akamai.net/assets.github.com/images/gravatars/gravatar-user-420.png?1345673561"/>
    <meta property="og:site_name" content="GitHub"/>
    <meta property="og:description" content="ColumnFilterWidgets - This is an add-on for the DataTables plugin (v1.7.x) for jQuery that creates filtering widgets based on the data in table columns."/>

    <meta name="description" content="ColumnFilterWidgets - This is an add-on for the DataTables plugin (v1.7.x) for jQuery that creates filtering widgets based on the data in table columns." />

  <link href="https://github.com/cyberhobo/ColumnFilterWidgets/commits/master.atom" rel="alternate" title="Recent Commits to ColumnFilterWidgets:master" type="application/atom+xml" />

  </head>


  <body class="logged_out page-blob windows vis-public env-production ">
    <div id="wrapper">

    
    

      <div id="header" class="true clearfix">
        <div class="container clearfix">
          <a class="site-logo " href="https://github.com/">
            <img alt="GitHub" class="github-logo-4x" height="30" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov7@4x.png?1338945075" />
            <img alt="GitHub" class="github-logo-4x-hover" height="30" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov7@4x-hover.png?1338945075" />
          </a>


                  <!--
      make sure to use fully qualified URLs here since this nav
      is used on error pages on other domains
    -->
    <ul class="top-nav logged_out">
        <li class="pricing"><a href="https://github.com/plans">Signup and Pricing</a></li>
        <li class="explore"><a href="https://github.com/explore">Explore GitHub</a></li>
      <li class="features"><a href="https://github.com/features">Features</a></li>
        <li class="blog"><a href="https://github.com/blog">Blog</a></li>
      <li class="login"><a href="https://github.com/login?return_to=%2Fcyberhobo%2FColumnFilterWidgets%2Fblob%2Fmaster%2Fmedia%2Fjs%2FColumnFilterWidgets.js">Sign in</a></li>
    </ul>



          
        </div>
      </div>

      

      

            <div class="site hfeed" itemscope itemtype="http://schema.org/WebPage">
      <div class="container hentry">
        
        <div class="pagehead repohead instapaper_ignore readability-menu">
        <div class="title-actions-bar">
          


              <ul class="pagehead-actions">


          <li>
            <span class="star-button"><a href="/login?return_to=%2Fcyberhobo%2FColumnFilterWidgets" class="minibutton js-toggler-target entice tooltipped leftwards" title="You must be signed in to use this feature" rel="nofollow"><span class="mini-icon mini-icon-star"></span>Star</a><a class="social-count js-social-count" href="/cyberhobo/ColumnFilterWidgets/stargazers">24</a></span>
          </li>
          <li>
            <a href="/login?return_to=%2Fcyberhobo%2FColumnFilterWidgets" class="minibutton js-toggler-target fork-button entice tooltipped leftwards"  title="You must be signed in to fork a repository" rel="nofollow"><span class="mini-icon mini-icon-fork"></span>Fork</a><a href="/cyberhobo/ColumnFilterWidgets/network" class="social-count">6</a>
          </li>
    </ul>

          <h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="entry-title public">
            <span class="repo-label"><span>public</span></span>
            <span class="mega-icon mega-icon-public-repo"></span>
            <span class="author vcard">
<a href="/cyberhobo" class="url fn" itemprop="url" rel="author">              <span itemprop="title">cyberhobo</span>
              </a></span> /
            <strong><a href="/cyberhobo/ColumnFilterWidgets" class="js-current-repository">ColumnFilterWidgets</a></strong>
          </h1>
        </div>

          

  <ul class="tabs">
    <li><a href="/cyberhobo/ColumnFilterWidgets" class="selected" highlight="repo_sourcerepo_downloadsrepo_commitsrepo_tagsrepo_branches">Code</a></li>
    <li><a href="/cyberhobo/ColumnFilterWidgets/network" highlight="repo_network">Network</a></li>
    <li><a href="/cyberhobo/ColumnFilterWidgets/pulls" highlight="repo_pulls">Pull Requests <span class='counter'>0</span></a></li>

      <li><a href="/cyberhobo/ColumnFilterWidgets/issues" highlight="repo_issues">Issues <span class='counter'>10</span></a></li>



    <li><a href="/cyberhobo/ColumnFilterWidgets/graphs" highlight="repo_graphsrepo_contributors">Graphs</a></li>


  </ul>
  
<div class="frame frame-center tree-finder" style="display:none"
      data-tree-list-url="/cyberhobo/ColumnFilterWidgets/tree-list/c1bb020583ac0fccf04425cbaa7713b6070aa6ca"
      data-blob-url-prefix="/cyberhobo/ColumnFilterWidgets/blob/c1bb020583ac0fccf04425cbaa7713b6070aa6ca"
    >

  <div class="breadcrumb">
    <span class="bold"><a href="/cyberhobo/ColumnFilterWidgets">ColumnFilterWidgets</a></span> /
    <input class="tree-finder-input js-navigation-enable" type="text" name="query" autocomplete="off" spellcheck="false">
  </div>

    <div class="octotip">
      <p>
        <a href="/cyberhobo/ColumnFilterWidgets/dismiss-tree-finder-help" class="dismiss js-dismiss-tree-list-help" title="Hide this notice forever" rel="nofollow">Dismiss</a>
        <span class="bold">Octotip:</span> You've activated the <em>file finder</em>
        by pressing <span class="kbd">t</span> Start typing to filter the
        file list. Use <span class="kbd badmono">↑</span> and
        <span class="kbd badmono">↓</span> to navigate,
        <span class="kbd">enter</span> to view files.
      </p>
    </div>

  <table class="tree-browser" cellpadding="0" cellspacing="0">
    <tr class="js-header"><th>&nbsp;</th><th>name</th></tr>
    <tr class="js-no-results no-results" style="display: none">
      <th colspan="2">No matching files</th>
    </tr>
    <tbody class="js-results-list js-navigation-container">
    </tbody>
  </table>
</div>

<div id="jump-to-line" style="display:none">
  <h2>Jump to Line</h2>
  <form accept-charset="UTF-8">
    <input class="textfield" type="text">
    <div class="full-button">
      <button type="submit" class="classy">
        Go
      </button>
    </div>
  </form>
</div>


<div class="tabnav">

  <span class="tabnav-right">
    <ul class="tabnav-tabs">
      <li><a href="/cyberhobo/ColumnFilterWidgets/tags" class="tabnav-tab" highlight="repo_tags">Tags <span class="counter ">2</span></a></li>
      <li><a href="/cyberhobo/ColumnFilterWidgets/downloads" class="tabnav-tab" highlight="repo_downloads">Downloads <span class="counter blank">0</span></a></li>
    </ul>
    
  </span>

  <div class="tabnav-widget scope">

    <div class="context-menu-container js-menu-container js-context-menu">
      <a href="#"
         class="minibutton bigger switcher js-menu-target js-commitish-button btn-branch repo-tree"
         data-hotkey="w"
         data-master-branch="master"
         data-ref="master">
         <span><em class="mini-icon mini-icon-branch"></em><i>branch:</i> master</span>
      </a>

      <div class="context-pane commitish-context js-menu-content">
        <a href="javascript:;" class="close js-menu-close"><span class="mini-icon mini-icon-remove-close"></span></a>
        <div class="context-title">Switch branches/tags</div>
        <div class="context-body pane-selector commitish-selector js-navigation-container">
          <div class="filterbar">
            <input type="text" id="context-commitish-filter-field" class="js-navigation-enable" placeholder="Filter branches/tags" data-filterable />
            <ul class="tabs">
              <li><a href="#" data-filter="branches" class="selected">Branches</a></li>
              <li><a href="#" data-filter="tags">Tags</a></li>
            </ul>
          </div>

          <div class="js-filter-tab js-filter-branches" data-filterable-for="context-commitish-filter-field" data-filterable-type=substring>
            <div class="no-results js-not-filterable">Nothing to show</div>
              <div class="commitish-item branch-commitish selector-item js-navigation-item js-navigation-target selected">
                <span class="mini-icon mini-icon-confirm"></span>
                <h4>
                    <a href="/cyberhobo/ColumnFilterWidgets/blob/master/media/js/ColumnFilterWidgets.js" class="js-navigation-open" data-name="master" rel="nofollow">master</a>
                </h4>
              </div>
          </div>

          <div class="js-filter-tab js-filter-tags" style="display:none" data-filterable-for="context-commitish-filter-field" data-filterable-type=substring>
            <div class="no-results js-not-filterable">Nothing to show</div>
              <div class="commitish-item tag-commitish selector-item js-navigation-item js-navigation-target ">
                <span class="mini-icon mini-icon-confirm"></span>
                <h4>
                    <a href="/cyberhobo/ColumnFilterWidgets/blob/1.0.3/media/js/ColumnFilterWidgets.js" class="js-navigation-open" data-name="1.0.3" rel="nofollow">1.0.3</a>
                </h4>
              </div>
              <div class="commitish-item tag-commitish selector-item js-navigation-item js-navigation-target ">
                <span class="mini-icon mini-icon-confirm"></span>
                <h4>
                    <a href="/cyberhobo/ColumnFilterWidgets/blob/1.0.2/media/js/ColumnFilterWidgets.js" class="js-navigation-open" data-name="1.0.2" rel="nofollow">1.0.2</a>
                </h4>
              </div>
          </div>
        </div>
      </div><!-- /.commitish-context-context -->
    </div>
  </div> <!-- /.scope -->

  <ul class="tabnav-tabs">
    <li><a href="/cyberhobo/ColumnFilterWidgets" class="selected tabnav-tab" highlight="repo_source">Files</a></li>
    <li><a href="/cyberhobo/ColumnFilterWidgets/commits/master" class="tabnav-tab" highlight="repo_commits">Commits</a></li>
    <li><a href="/cyberhobo/ColumnFilterWidgets/branches" class="tabnav-tab" highlight="repo_branches" rel="nofollow">Branches <span class="counter ">1</span></a></li>
  </ul>

</div>

  
  
  


          

        </div><!-- /.repohead -->

        <div id="js-repo-pjax-container" data-pjax-container>
          


<!-- blob contrib key: blob_contributors:v21:0cb5f4b4e56455379531ad6ffd4d0db4 -->
<!-- blob contrib frag key: views10/v8/blob_contributors:v21:0cb5f4b4e56455379531ad6ffd4d0db4 -->

<!-- block_view_fragment_key: views10/v8/blob:v21:c7733ac872c1f909c8ed41d9b0695d3c -->
  <div id="slider">

    <div class="breadcrumb" data-path="media/js/ColumnFilterWidgets.js/">
      <b itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/cyberhobo/ColumnFilterWidgets/tree/c1bb020583ac0fccf04425cbaa7713b6070aa6ca" class="js-rewrite-sha" itemprop="url"><span itemprop="title">ColumnFilterWidgets</span></a></b> / <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/cyberhobo/ColumnFilterWidgets/tree/c1bb020583ac0fccf04425cbaa7713b6070aa6ca/media" class="js-rewrite-sha" itemscope="url"><span itemprop="title">media</span></a></span> / <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/cyberhobo/ColumnFilterWidgets/tree/c1bb020583ac0fccf04425cbaa7713b6070aa6ca/media/js" class="js-rewrite-sha" itemscope="url"><span itemprop="title">js</span></a></span> / <strong class="final-path">ColumnFilterWidgets.js</strong> <span class="js-clippy mini-icon mini-icon-clippy " data-clipboard-text="media/js/ColumnFilterWidgets.js" data-copied-hint="copied!" data-copy-hint="copy to clipboard"></span>
    </div>

      
  <div class="commit file-history-tease js-blob-contributors-content" data-path="media/js/ColumnFilterWidgets.js/">
    <img class="main-avatar" height="24" src="https://secure.gravatar.com/avatar/ec6e748914830d5c071b6ab264107067?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
    <span class="author"><a href="/cyberhobo">cyberhobo</a></span>
    <time class="js-relative-date" datetime="2012-06-14T16:18:34-07:00" title="2012-06-14 16:18:34">June 14, 2012</time>
    <div class="commit-title">
        <a href="/cyberhobo/ColumnFilterWidgets/commit/01efef439c557154bad3d61aa00d47285b6d21d6" class="message">Added column sorting and other option overrides, closes issue </a><a title="More flexible widget menu sorting" class="issue-link" href="https://github.com/cyberhobo/ColumnFilterWidgets/issues/4">#4</a><a href="/cyberhobo/ColumnFilterWidgets/commit/01efef439c557154bad3d61aa00d47285b6d21d6" class="message">.</a>
    </div>

    <div class="participation">
      <p class="quickstat"><a href="#blob_contributors_box" rel="facebox"><strong>1</strong> contributor</a></p>
      
    </div>
    <div id="blob_contributors_box" style="display:none">
      <h2>Users on GitHub who have contributed to this file</h2>
      <ul class="facebox-user-list">
        <li>
          <img height="24" src="https://secure.gravatar.com/avatar/ec6e748914830d5c071b6ab264107067?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/cyberhobo">cyberhobo</a>
        </li>
      </ul>
    </div>
  </div>


    <div class="frames">
      <div class="frame frame-center" data-path="media/js/ColumnFilterWidgets.js/" data-permalink-url="/cyberhobo/ColumnFilterWidgets/blob/c1bb020583ac0fccf04425cbaa7713b6070aa6ca/media/js/ColumnFilterWidgets.js" data-title="ColumnFilterWidgets/media/js/ColumnFilterWidgets.js at master · cyberhobo/ColumnFilterWidgets · GitHub" data-type="blob">

        <div id="files" class="bubble">
          <div class="file">
            <div class="meta">
              <div class="info">
                <span class="icon"><b class="mini-icon mini-icon-text-file"></b></span>
                <span class="mode" title="File Mode">file</span>
                  <span>321 lines (294 sloc)</span>
                <span>11.468 kb</span>
              </div>
              <ul class="button-group actions">
                  <li>
                    <a class="grouped-button file-edit-link minibutton bigger lighter js-rewrite-sha" href="/cyberhobo/ColumnFilterWidgets/edit/c1bb020583ac0fccf04425cbaa7713b6070aa6ca/media/js/ColumnFilterWidgets.js" data-method="post" rel="nofollow" data-hotkey="e">Edit</a>
                  </li>
                <li>
                  <a href="/cyberhobo/ColumnFilterWidgets/raw/master/media/js/ColumnFilterWidgets.js" class="minibutton grouped-button bigger lighter" id="raw-url">Raw</a>
                </li>
                  <li>
                    <a href="/cyberhobo/ColumnFilterWidgets/blame/master/media/js/ColumnFilterWidgets.js" class="minibutton grouped-button bigger lighter">Blame</a>
                  </li>
                <li>
                  <a href="/cyberhobo/ColumnFilterWidgets/commits/master/media/js/ColumnFilterWidgets.js" class="minibutton grouped-button bigger lighter" rel="nofollow">History</a>
                </li>
              </ul>
            </div>
              <div class="data type-javascript">
      <table cellpadding="0" cellspacing="0" class="lines">
        <tr>
          <td>
            <pre class="line_numbers"><span id="L1" rel="#L1">1</span>
<span id="L2" rel="#L2">2</span>
<span id="L3" rel="#L3">3</span>
<span id="L4" rel="#L4">4</span>
<span id="L5" rel="#L5">5</span>
<span id="L6" rel="#L6">6</span>
<span id="L7" rel="#L7">7</span>
<span id="L8" rel="#L8">8</span>
<span id="L9" rel="#L9">9</span>
<span id="L10" rel="#L10">10</span>
<span id="L11" rel="#L11">11</span>
<span id="L12" rel="#L12">12</span>
<span id="L13" rel="#L13">13</span>
<span id="L14" rel="#L14">14</span>
<span id="L15" rel="#L15">15</span>
<span id="L16" rel="#L16">16</span>
<span id="L17" rel="#L17">17</span>
<span id="L18" rel="#L18">18</span>
<span id="L19" rel="#L19">19</span>
<span id="L20" rel="#L20">20</span>
<span id="L21" rel="#L21">21</span>
<span id="L22" rel="#L22">22</span>
<span id="L23" rel="#L23">23</span>
<span id="L24" rel="#L24">24</span>
<span id="L25" rel="#L25">25</span>
<span id="L26" rel="#L26">26</span>
<span id="L27" rel="#L27">27</span>
<span id="L28" rel="#L28">28</span>
<span id="L29" rel="#L29">29</span>
<span id="L30" rel="#L30">30</span>
<span id="L31" rel="#L31">31</span>
<span id="L32" rel="#L32">32</span>
<span id="L33" rel="#L33">33</span>
<span id="L34" rel="#L34">34</span>
<span id="L35" rel="#L35">35</span>
<span id="L36" rel="#L36">36</span>
<span id="L37" rel="#L37">37</span>
<span id="L38" rel="#L38">38</span>
<span id="L39" rel="#L39">39</span>
<span id="L40" rel="#L40">40</span>
<span id="L41" rel="#L41">41</span>
<span id="L42" rel="#L42">42</span>
<span id="L43" rel="#L43">43</span>
<span id="L44" rel="#L44">44</span>
<span id="L45" rel="#L45">45</span>
<span id="L46" rel="#L46">46</span>
<span id="L47" rel="#L47">47</span>
<span id="L48" rel="#L48">48</span>
<span id="L49" rel="#L49">49</span>
<span id="L50" rel="#L50">50</span>
<span id="L51" rel="#L51">51</span>
<span id="L52" rel="#L52">52</span>
<span id="L53" rel="#L53">53</span>
<span id="L54" rel="#L54">54</span>
<span id="L55" rel="#L55">55</span>
<span id="L56" rel="#L56">56</span>
<span id="L57" rel="#L57">57</span>
<span id="L58" rel="#L58">58</span>
<span id="L59" rel="#L59">59</span>
<span id="L60" rel="#L60">60</span>
<span id="L61" rel="#L61">61</span>
<span id="L62" rel="#L62">62</span>
<span id="L63" rel="#L63">63</span>
<span id="L64" rel="#L64">64</span>
<span id="L65" rel="#L65">65</span>
<span id="L66" rel="#L66">66</span>
<span id="L67" rel="#L67">67</span>
<span id="L68" rel="#L68">68</span>
<span id="L69" rel="#L69">69</span>
<span id="L70" rel="#L70">70</span>
<span id="L71" rel="#L71">71</span>
<span id="L72" rel="#L72">72</span>
<span id="L73" rel="#L73">73</span>
<span id="L74" rel="#L74">74</span>
<span id="L75" rel="#L75">75</span>
<span id="L76" rel="#L76">76</span>
<span id="L77" rel="#L77">77</span>
<span id="L78" rel="#L78">78</span>
<span id="L79" rel="#L79">79</span>
<span id="L80" rel="#L80">80</span>
<span id="L81" rel="#L81">81</span>
<span id="L82" rel="#L82">82</span>
<span id="L83" rel="#L83">83</span>
<span id="L84" rel="#L84">84</span>
<span id="L85" rel="#L85">85</span>
<span id="L86" rel="#L86">86</span>
<span id="L87" rel="#L87">87</span>
<span id="L88" rel="#L88">88</span>
<span id="L89" rel="#L89">89</span>
<span id="L90" rel="#L90">90</span>
<span id="L91" rel="#L91">91</span>
<span id="L92" rel="#L92">92</span>
<span id="L93" rel="#L93">93</span>
<span id="L94" rel="#L94">94</span>
<span id="L95" rel="#L95">95</span>
<span id="L96" rel="#L96">96</span>
<span id="L97" rel="#L97">97</span>
<span id="L98" rel="#L98">98</span>
<span id="L99" rel="#L99">99</span>
<span id="L100" rel="#L100">100</span>
<span id="L101" rel="#L101">101</span>
<span id="L102" rel="#L102">102</span>
<span id="L103" rel="#L103">103</span>
<span id="L104" rel="#L104">104</span>
<span id="L105" rel="#L105">105</span>
<span id="L106" rel="#L106">106</span>
<span id="L107" rel="#L107">107</span>
<span id="L108" rel="#L108">108</span>
<span id="L109" rel="#L109">109</span>
<span id="L110" rel="#L110">110</span>
<span id="L111" rel="#L111">111</span>
<span id="L112" rel="#L112">112</span>
<span id="L113" rel="#L113">113</span>
<span id="L114" rel="#L114">114</span>
<span id="L115" rel="#L115">115</span>
<span id="L116" rel="#L116">116</span>
<span id="L117" rel="#L117">117</span>
<span id="L118" rel="#L118">118</span>
<span id="L119" rel="#L119">119</span>
<span id="L120" rel="#L120">120</span>
<span id="L121" rel="#L121">121</span>
<span id="L122" rel="#L122">122</span>
<span id="L123" rel="#L123">123</span>
<span id="L124" rel="#L124">124</span>
<span id="L125" rel="#L125">125</span>
<span id="L126" rel="#L126">126</span>
<span id="L127" rel="#L127">127</span>
<span id="L128" rel="#L128">128</span>
<span id="L129" rel="#L129">129</span>
<span id="L130" rel="#L130">130</span>
<span id="L131" rel="#L131">131</span>
<span id="L132" rel="#L132">132</span>
<span id="L133" rel="#L133">133</span>
<span id="L134" rel="#L134">134</span>
<span id="L135" rel="#L135">135</span>
<span id="L136" rel="#L136">136</span>
<span id="L137" rel="#L137">137</span>
<span id="L138" rel="#L138">138</span>
<span id="L139" rel="#L139">139</span>
<span id="L140" rel="#L140">140</span>
<span id="L141" rel="#L141">141</span>
<span id="L142" rel="#L142">142</span>
<span id="L143" rel="#L143">143</span>
<span id="L144" rel="#L144">144</span>
<span id="L145" rel="#L145">145</span>
<span id="L146" rel="#L146">146</span>
<span id="L147" rel="#L147">147</span>
<span id="L148" rel="#L148">148</span>
<span id="L149" rel="#L149">149</span>
<span id="L150" rel="#L150">150</span>
<span id="L151" rel="#L151">151</span>
<span id="L152" rel="#L152">152</span>
<span id="L153" rel="#L153">153</span>
<span id="L154" rel="#L154">154</span>
<span id="L155" rel="#L155">155</span>
<span id="L156" rel="#L156">156</span>
<span id="L157" rel="#L157">157</span>
<span id="L158" rel="#L158">158</span>
<span id="L159" rel="#L159">159</span>
<span id="L160" rel="#L160">160</span>
<span id="L161" rel="#L161">161</span>
<span id="L162" rel="#L162">162</span>
<span id="L163" rel="#L163">163</span>
<span id="L164" rel="#L164">164</span>
<span id="L165" rel="#L165">165</span>
<span id="L166" rel="#L166">166</span>
<span id="L167" rel="#L167">167</span>
<span id="L168" rel="#L168">168</span>
<span id="L169" rel="#L169">169</span>
<span id="L170" rel="#L170">170</span>
<span id="L171" rel="#L171">171</span>
<span id="L172" rel="#L172">172</span>
<span id="L173" rel="#L173">173</span>
<span id="L174" rel="#L174">174</span>
<span id="L175" rel="#L175">175</span>
<span id="L176" rel="#L176">176</span>
<span id="L177" rel="#L177">177</span>
<span id="L178" rel="#L178">178</span>
<span id="L179" rel="#L179">179</span>
<span id="L180" rel="#L180">180</span>
<span id="L181" rel="#L181">181</span>
<span id="L182" rel="#L182">182</span>
<span id="L183" rel="#L183">183</span>
<span id="L184" rel="#L184">184</span>
<span id="L185" rel="#L185">185</span>
<span id="L186" rel="#L186">186</span>
<span id="L187" rel="#L187">187</span>
<span id="L188" rel="#L188">188</span>
<span id="L189" rel="#L189">189</span>
<span id="L190" rel="#L190">190</span>
<span id="L191" rel="#L191">191</span>
<span id="L192" rel="#L192">192</span>
<span id="L193" rel="#L193">193</span>
<span id="L194" rel="#L194">194</span>
<span id="L195" rel="#L195">195</span>
<span id="L196" rel="#L196">196</span>
<span id="L197" rel="#L197">197</span>
<span id="L198" rel="#L198">198</span>
<span id="L199" rel="#L199">199</span>
<span id="L200" rel="#L200">200</span>
<span id="L201" rel="#L201">201</span>
<span id="L202" rel="#L202">202</span>
<span id="L203" rel="#L203">203</span>
<span id="L204" rel="#L204">204</span>
<span id="L205" rel="#L205">205</span>
<span id="L206" rel="#L206">206</span>
<span id="L207" rel="#L207">207</span>
<span id="L208" rel="#L208">208</span>
<span id="L209" rel="#L209">209</span>
<span id="L210" rel="#L210">210</span>
<span id="L211" rel="#L211">211</span>
<span id="L212" rel="#L212">212</span>
<span id="L213" rel="#L213">213</span>
<span id="L214" rel="#L214">214</span>
<span id="L215" rel="#L215">215</span>
<span id="L216" rel="#L216">216</span>
<span id="L217" rel="#L217">217</span>
<span id="L218" rel="#L218">218</span>
<span id="L219" rel="#L219">219</span>
<span id="L220" rel="#L220">220</span>
<span id="L221" rel="#L221">221</span>
<span id="L222" rel="#L222">222</span>
<span id="L223" rel="#L223">223</span>
<span id="L224" rel="#L224">224</span>
<span id="L225" rel="#L225">225</span>
<span id="L226" rel="#L226">226</span>
<span id="L227" rel="#L227">227</span>
<span id="L228" rel="#L228">228</span>
<span id="L229" rel="#L229">229</span>
<span id="L230" rel="#L230">230</span>
<span id="L231" rel="#L231">231</span>
<span id="L232" rel="#L232">232</span>
<span id="L233" rel="#L233">233</span>
<span id="L234" rel="#L234">234</span>
<span id="L235" rel="#L235">235</span>
<span id="L236" rel="#L236">236</span>
<span id="L237" rel="#L237">237</span>
<span id="L238" rel="#L238">238</span>
<span id="L239" rel="#L239">239</span>
<span id="L240" rel="#L240">240</span>
<span id="L241" rel="#L241">241</span>
<span id="L242" rel="#L242">242</span>
<span id="L243" rel="#L243">243</span>
<span id="L244" rel="#L244">244</span>
<span id="L245" rel="#L245">245</span>
<span id="L246" rel="#L246">246</span>
<span id="L247" rel="#L247">247</span>
<span id="L248" rel="#L248">248</span>
<span id="L249" rel="#L249">249</span>
<span id="L250" rel="#L250">250</span>
<span id="L251" rel="#L251">251</span>
<span id="L252" rel="#L252">252</span>
<span id="L253" rel="#L253">253</span>
<span id="L254" rel="#L254">254</span>
<span id="L255" rel="#L255">255</span>
<span id="L256" rel="#L256">256</span>
<span id="L257" rel="#L257">257</span>
<span id="L258" rel="#L258">258</span>
<span id="L259" rel="#L259">259</span>
<span id="L260" rel="#L260">260</span>
<span id="L261" rel="#L261">261</span>
<span id="L262" rel="#L262">262</span>
<span id="L263" rel="#L263">263</span>
<span id="L264" rel="#L264">264</span>
<span id="L265" rel="#L265">265</span>
<span id="L266" rel="#L266">266</span>
<span id="L267" rel="#L267">267</span>
<span id="L268" rel="#L268">268</span>
<span id="L269" rel="#L269">269</span>
<span id="L270" rel="#L270">270</span>
<span id="L271" rel="#L271">271</span>
<span id="L272" rel="#L272">272</span>
<span id="L273" rel="#L273">273</span>
<span id="L274" rel="#L274">274</span>
<span id="L275" rel="#L275">275</span>
<span id="L276" rel="#L276">276</span>
<span id="L277" rel="#L277">277</span>
<span id="L278" rel="#L278">278</span>
<span id="L279" rel="#L279">279</span>
<span id="L280" rel="#L280">280</span>
<span id="L281" rel="#L281">281</span>
<span id="L282" rel="#L282">282</span>
<span id="L283" rel="#L283">283</span>
<span id="L284" rel="#L284">284</span>
<span id="L285" rel="#L285">285</span>
<span id="L286" rel="#L286">286</span>
<span id="L287" rel="#L287">287</span>
<span id="L288" rel="#L288">288</span>
<span id="L289" rel="#L289">289</span>
<span id="L290" rel="#L290">290</span>
<span id="L291" rel="#L291">291</span>
<span id="L292" rel="#L292">292</span>
<span id="L293" rel="#L293">293</span>
<span id="L294" rel="#L294">294</span>
<span id="L295" rel="#L295">295</span>
<span id="L296" rel="#L296">296</span>
<span id="L297" rel="#L297">297</span>
<span id="L298" rel="#L298">298</span>
<span id="L299" rel="#L299">299</span>
<span id="L300" rel="#L300">300</span>
<span id="L301" rel="#L301">301</span>
<span id="L302" rel="#L302">302</span>
<span id="L303" rel="#L303">303</span>
<span id="L304" rel="#L304">304</span>
<span id="L305" rel="#L305">305</span>
<span id="L306" rel="#L306">306</span>
<span id="L307" rel="#L307">307</span>
<span id="L308" rel="#L308">308</span>
<span id="L309" rel="#L309">309</span>
<span id="L310" rel="#L310">310</span>
<span id="L311" rel="#L311">311</span>
<span id="L312" rel="#L312">312</span>
<span id="L313" rel="#L313">313</span>
<span id="L314" rel="#L314">314</span>
<span id="L315" rel="#L315">315</span>
<span id="L316" rel="#L316">316</span>
<span id="L317" rel="#L317">317</span>
<span id="L318" rel="#L318">318</span>
<span id="L319" rel="#L319">319</span>
<span id="L320" rel="#L320">320</span>
</pre>
          </td>
          <td width="100%">
                <div class="highlight"><pre><div class='line' id='LC1'><span class="cm">/*</span></div><div class='line' id='LC2'><span class="cm"> * File:        ColumnFilterWidgets.js</span></div><div class='line' id='LC3'><span class="cm"> * Version:     1.0.2</span></div><div class='line' id='LC4'><span class="cm"> * Description: Controls for filtering based on unique column values in DataTables</span></div><div class='line' id='LC5'><span class="cm"> * Author:      Dylan Kuhn (www.cyberhobo.net)</span></div><div class='line' id='LC6'><span class="cm"> * Language:    Javascript</span></div><div class='line' id='LC7'><span class="cm"> * License:     GPL v2 or BSD 3 point style</span></div><div class='line' id='LC8'><span class="cm"> * Contact:     cyberhobo@cyberhobo.net</span></div><div class='line' id='LC9'><span class="cm"> * </span></div><div class='line' id='LC10'><span class="cm"> * Copyright 2011 Dylan Kuhn (except fnGetColumnData by Benedikt Forchhammer), all rights reserved.</span></div><div class='line' id='LC11'><span class="cm"> *</span></div><div class='line' id='LC12'><span class="cm"> * This source file is free software, under either the GPL v2 license or a</span></div><div class='line' id='LC13'><span class="cm"> * BSD style license, available at:</span></div><div class='line' id='LC14'><span class="cm"> *   http://datatables.net/license_gpl2</span></div><div class='line' id='LC15'><span class="cm"> *   http://datatables.net/license_bsd</span></div><div class='line' id='LC16'><span class="cm"> */</span></div><div class='line' id='LC17'><br/></div><div class='line' id='LC18'><span class="p">(</span><span class="kd">function</span><span class="p">(</span><span class="nx">$</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC19'>	<span class="cm">/*</span></div><div class='line' id='LC20'><span class="cm">	 * Function: fnGetColumnData</span></div><div class='line' id='LC21'><span class="cm">	 * Purpose:  Return an array of table values from a particular column.</span></div><div class='line' id='LC22'><span class="cm">	 * Returns:  array string: 1d data array </span></div><div class='line' id='LC23'><span class="cm">	 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function</span></div><div class='line' id='LC24'><span class="cm">	 *           int:iColumn - the id of the column to extract the data from</span></div><div class='line' id='LC25'><span class="cm">	 *           bool:bUnique - optional - if set to false duplicated values are not filtered out</span></div><div class='line' id='LC26'><span class="cm">	 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)</span></div><div class='line' id='LC27'><span class="cm">	 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array</span></div><div class='line' id='LC28'><span class="cm">	 * Author:   Benedikt Forchhammer &lt;b.forchhammer /AT\ mind2.de&gt;</span></div><div class='line' id='LC29'><span class="cm">	 */</span></div><div class='line' id='LC30'><br/></div><div class='line' id='LC31'>	<span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">dataTableExt</span><span class="p">.</span><span class="nx">oApi</span><span class="p">.</span><span class="nx">fnGetColumnData</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">(</span> <span class="nx">oSettings</span><span class="p">,</span> <span class="nx">iColumn</span><span class="p">,</span> <span class="nx">bUnique</span><span class="p">,</span> <span class="nx">bFiltered</span><span class="p">,</span> <span class="nx">bIgnoreEmpty</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC32'>		<span class="c1">// check that we have a column id</span></div><div class='line' id='LC33'>		<span class="k">if</span> <span class="p">(</span> <span class="k">typeof</span> <span class="nx">iColumn</span> <span class="o">==</span> <span class="s2">&quot;undefined&quot;</span> <span class="p">)</span> <span class="k">return</span> <span class="k">new</span> <span class="nb">Array</span><span class="p">();</span></div><div class='line' id='LC34'><br/></div><div class='line' id='LC35'>		<span class="c1">// by default we only wany unique data</span></div><div class='line' id='LC36'>		<span class="k">if</span> <span class="p">(</span> <span class="k">typeof</span> <span class="nx">bUnique</span> <span class="o">==</span> <span class="s2">&quot;undefined&quot;</span> <span class="p">)</span> <span class="nx">bUnique</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC37'><br/></div><div class='line' id='LC38'>		<span class="c1">// by default we do want to only look at filtered data</span></div><div class='line' id='LC39'>		<span class="k">if</span> <span class="p">(</span> <span class="k">typeof</span> <span class="nx">bFiltered</span> <span class="o">==</span> <span class="s2">&quot;undefined&quot;</span> <span class="p">)</span> <span class="nx">bFiltered</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC40'><br/></div><div class='line' id='LC41'>		<span class="c1">// by default we do not wany to include empty values</span></div><div class='line' id='LC42'>		<span class="k">if</span> <span class="p">(</span> <span class="k">typeof</span> <span class="nx">bIgnoreEmpty</span> <span class="o">==</span> <span class="s2">&quot;undefined&quot;</span> <span class="p">)</span> <span class="nx">bIgnoreEmpty</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC43'><br/></div><div class='line' id='LC44'>		<span class="c1">// list of rows which we&#39;re going to loop through</span></div><div class='line' id='LC45'>		<span class="kd">var</span> <span class="nx">aiRows</span><span class="p">;</span></div><div class='line' id='LC46'><br/></div><div class='line' id='LC47'>		<span class="c1">// use only filtered rows</span></div><div class='line' id='LC48'>		<span class="k">if</span> <span class="p">(</span><span class="nx">bFiltered</span> <span class="o">==</span> <span class="kc">true</span><span class="p">)</span> <span class="nx">aiRows</span> <span class="o">=</span> <span class="nx">oSettings</span><span class="p">.</span><span class="nx">aiDisplay</span><span class="p">;</span> </div><div class='line' id='LC49'>		<span class="c1">// use all rows</span></div><div class='line' id='LC50'>		<span class="k">else</span> <span class="nx">aiRows</span> <span class="o">=</span> <span class="nx">oSettings</span><span class="p">.</span><span class="nx">aiDisplayMaster</span><span class="p">;</span> <span class="c1">// all row numbers</span></div><div class='line' id='LC51'><br/></div><div class='line' id='LC52'>		<span class="c1">// set up data array	</span></div><div class='line' id='LC53'>		<span class="kd">var</span> <span class="nx">asResultData</span> <span class="o">=</span> <span class="k">new</span> <span class="nb">Array</span><span class="p">();</span></div><div class='line' id='LC54'><br/></div><div class='line' id='LC55'>		<span class="k">for</span> <span class="p">(</span><span class="kd">var</span> <span class="nx">i</span><span class="o">=</span><span class="mi">0</span><span class="p">,</span><span class="nx">c</span><span class="o">=</span><span class="nx">aiRows</span><span class="p">.</span><span class="nx">length</span><span class="p">;</span> <span class="nx">i</span><span class="o">&lt;</span><span class="nx">c</span><span class="p">;</span> <span class="nx">i</span><span class="o">++</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC56'>			<span class="nx">iRow</span> <span class="o">=</span> <span class="nx">aiRows</span><span class="p">[</span><span class="nx">i</span><span class="p">];</span></div><div class='line' id='LC57'>			<span class="kd">var</span> <span class="nx">aData</span> <span class="o">=</span> <span class="k">this</span><span class="p">.</span><span class="nx">fnGetData</span><span class="p">(</span><span class="nx">iRow</span><span class="p">);</span></div><div class='line' id='LC58'>			<span class="kd">var</span> <span class="nx">sValue</span> <span class="o">=</span> <span class="nx">aData</span><span class="p">[</span><span class="nx">iColumn</span><span class="p">];</span></div><div class='line' id='LC59'><br/></div><div class='line' id='LC60'>			<span class="c1">// ignore empty values?</span></div><div class='line' id='LC61'>			<span class="k">if</span> <span class="p">(</span><span class="nx">bIgnoreEmpty</span> <span class="o">==</span> <span class="kc">true</span> <span class="o">&amp;&amp;</span> <span class="nx">sValue</span><span class="p">.</span><span class="nx">length</span> <span class="o">==</span> <span class="mi">0</span><span class="p">)</span> <span class="k">continue</span><span class="p">;</span></div><div class='line' id='LC62'><br/></div><div class='line' id='LC63'>			<span class="c1">// ignore unique values?</span></div><div class='line' id='LC64'>			<span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">bUnique</span> <span class="o">==</span> <span class="kc">true</span> <span class="o">&amp;&amp;</span> <span class="nx">jQuery</span><span class="p">.</span><span class="nx">inArray</span><span class="p">(</span><span class="nx">sValue</span><span class="p">,</span> <span class="nx">asResultData</span><span class="p">)</span> <span class="o">&gt;</span> <span class="o">-</span><span class="mi">1</span><span class="p">)</span> <span class="k">continue</span><span class="p">;</span></div><div class='line' id='LC65'><br/></div><div class='line' id='LC66'>			<span class="c1">// else push the value onto the result data array</span></div><div class='line' id='LC67'>			<span class="k">else</span> <span class="nx">asResultData</span><span class="p">.</span><span class="nx">push</span><span class="p">(</span><span class="nx">sValue</span><span class="p">);</span></div><div class='line' id='LC68'>		<span class="p">}</span></div><div class='line' id='LC69'><br/></div><div class='line' id='LC70'>		<span class="k">return</span> <span class="nx">asResultData</span><span class="p">;</span></div><div class='line' id='LC71'>	<span class="p">};</span></div><div class='line' id='LC72'><br/></div><div class='line' id='LC73'>	<span class="cm">/**</span></div><div class='line' id='LC74'><span class="cm">	* Add backslashes to regular expression symbols in a string.</span></div><div class='line' id='LC75'><span class="cm">	* </span></div><div class='line' id='LC76'><span class="cm">	* Allows a regular expression to be constructed to search for </span></div><div class='line' id='LC77'><span class="cm">	* variable text.</span></div><div class='line' id='LC78'><span class="cm">	* </span></div><div class='line' id='LC79'><span class="cm">	* @param string sText The text to escape.</span></div><div class='line' id='LC80'><span class="cm">	* @return string The escaped string.</span></div><div class='line' id='LC81'><span class="cm">	*/</span></div><div class='line' id='LC82'>	<span class="kd">var</span> <span class="nx">fnRegExpEscape</span> <span class="o">=</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">sText</span> <span class="p">)</span> <span class="p">{</span> </div><div class='line' id='LC83'>		<span class="k">return</span> <span class="nx">sText</span><span class="p">.</span><span class="nx">replace</span><span class="p">(</span><span class="sr">/[-[\]{}()*+?.,\\^$|#\s]/g</span><span class="p">,</span> <span class="s2">&quot;\\$&amp;&quot;</span><span class="p">);</span> </div><div class='line' id='LC84'>	<span class="p">};</span></div><div class='line' id='LC85'><br/></div><div class='line' id='LC86'>	<span class="cm">/**</span></div><div class='line' id='LC87'><span class="cm">	* Menu-based filter widgets based on distinct column values for a table.</span></div><div class='line' id='LC88'><span class="cm">	*</span></div><div class='line' id='LC89'><span class="cm">	* @class ColumnFilterWidgets </span></div><div class='line' id='LC90'><span class="cm">	* @constructor</span></div><div class='line' id='LC91'><span class="cm">	* @param {object} oDataTableSettings Settings for the target table.</span></div><div class='line' id='LC92'><span class="cm">	*/</span></div><div class='line' id='LC93'>	<span class="kd">var</span> <span class="nx">ColumnFilterWidgets</span> <span class="o">=</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">oDataTableSettings</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC94'>		<span class="kd">var</span> <span class="nx">me</span> <span class="o">=</span> <span class="k">this</span><span class="p">;</span></div><div class='line' id='LC95'>		<span class="kd">var</span> <span class="nx">sExcludeList</span> <span class="o">=</span> <span class="s1">&#39;&#39;</span><span class="p">;</span></div><div class='line' id='LC96'>		<span class="nx">me</span><span class="p">.</span><span class="nx">$WidgetContainer</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;div class=&quot;column-filter-widgets&quot;&gt;&lt;/div&gt;&#39;</span> <span class="p">);</span></div><div class='line' id='LC97'>		<span class="nx">me</span><span class="p">.</span><span class="nx">$MenuContainer</span> <span class="o">=</span> <span class="nx">me</span><span class="p">.</span><span class="nx">$WidgetContainer</span><span class="p">;</span></div><div class='line' id='LC98'>		<span class="nx">me</span><span class="p">.</span><span class="nx">$TermContainer</span> <span class="o">=</span> <span class="kc">null</span><span class="p">;</span></div><div class='line' id='LC99'>		<span class="nx">me</span><span class="p">.</span><span class="nx">aoWidgets</span> <span class="o">=</span> <span class="p">[];</span></div><div class='line' id='LC100'>		<span class="nx">me</span><span class="p">.</span><span class="nx">sSeparator</span> <span class="o">=</span> <span class="s1">&#39;&#39;</span><span class="p">;</span></div><div class='line' id='LC101'>		<span class="k">if</span> <span class="p">(</span> <span class="s1">&#39;oColumnFilterWidgets&#39;</span> <span class="k">in</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC102'>			<span class="k">if</span> <span class="p">(</span> <span class="s1">&#39;aiExclude&#39;</span> <span class="k">in</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC103'>				<span class="nx">sExcludeList</span> <span class="o">=</span> <span class="s1">&#39;|&#39;</span> <span class="o">+</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span><span class="p">.</span><span class="nx">aiExclude</span><span class="p">.</span><span class="nx">join</span><span class="p">(</span> <span class="s1">&#39;|&#39;</span> <span class="p">)</span> <span class="o">+</span> <span class="s1">&#39;|&#39;</span><span class="p">;</span></div><div class='line' id='LC104'>			<span class="p">}</span></div><div class='line' id='LC105'>			<span class="k">if</span> <span class="p">(</span> <span class="s1">&#39;bGroupTerms&#39;</span> <span class="k">in</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span> <span class="o">&amp;&amp;</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span><span class="p">.</span><span class="nx">bGroupTerms</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC106'>				<span class="nx">me</span><span class="p">.</span><span class="nx">$MenuContainer</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;div class=&quot;column-filter-widget-menus&quot;&gt;&lt;/div&gt;&#39;</span> <span class="p">);</span></div><div class='line' id='LC107'>				<span class="nx">me</span><span class="p">.</span><span class="nx">$TermContainer</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;div class=&quot;column-filter-widget-selected-terms&quot;&gt;&lt;/div&gt;&#39;</span> <span class="p">).</span><span class="nx">hide</span><span class="p">();</span></div><div class='line' id='LC108'>			<span class="p">}</span></div><div class='line' id='LC109'>		<span class="p">}</span></div><div class='line' id='LC110'><br/></div><div class='line' id='LC111'>		<span class="c1">// Add a widget for each visible and filtered column</span></div><div class='line' id='LC112'>		<span class="nx">$</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">aoColumns</span><span class="p">,</span> <span class="kd">function</span> <span class="p">(</span> <span class="nx">i</span><span class="p">,</span> <span class="nx">oColumn</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC113'>			<span class="kd">var</span> <span class="nx">$columnTh</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span> <span class="nx">oColumn</span><span class="p">.</span><span class="nx">nTh</span> <span class="p">);</span></div><div class='line' id='LC114'>			<span class="kd">var</span> <span class="nx">$WidgetElem</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;div class=&quot;column-filter-widget&quot;&gt;&lt;/div&gt;&#39;</span> <span class="p">);</span></div><div class='line' id='LC115'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">sExcludeList</span><span class="p">.</span><span class="nx">indexOf</span><span class="p">(</span> <span class="s1">&#39;|&#39;</span> <span class="o">+</span> <span class="nx">i</span> <span class="o">+</span> <span class="s1">&#39;|&#39;</span> <span class="p">)</span> <span class="o">&lt;</span> <span class="mi">0</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC116'>				<span class="nx">me</span><span class="p">.</span><span class="nx">aoWidgets</span><span class="p">.</span><span class="nx">push</span><span class="p">(</span> <span class="k">new</span> <span class="nx">ColumnFilterWidget</span><span class="p">(</span> <span class="nx">$WidgetElem</span><span class="p">,</span> <span class="nx">oDataTableSettings</span><span class="p">,</span> <span class="nx">i</span><span class="p">,</span> <span class="nx">me</span> <span class="p">)</span> <span class="p">);</span></div><div class='line' id='LC117'>			<span class="p">}</span></div><div class='line' id='LC118'>			<span class="nx">me</span><span class="p">.</span><span class="nx">$MenuContainer</span><span class="p">.</span><span class="nx">append</span><span class="p">(</span> <span class="nx">$WidgetElem</span> <span class="p">);</span></div><div class='line' id='LC119'>		<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC120'>		<span class="k">if</span> <span class="p">(</span> <span class="nx">me</span><span class="p">.</span><span class="nx">$TermContainer</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC121'>			<span class="nx">me</span><span class="p">.</span><span class="nx">$WidgetContainer</span><span class="p">.</span><span class="nx">append</span><span class="p">(</span> <span class="nx">me</span><span class="p">.</span><span class="nx">$MenuContainer</span> <span class="p">);</span></div><div class='line' id='LC122'>			<span class="nx">me</span><span class="p">.</span><span class="nx">$WidgetContainer</span><span class="p">.</span><span class="nx">append</span><span class="p">(</span> <span class="nx">me</span><span class="p">.</span><span class="nx">$TermContainer</span> <span class="p">);</span></div><div class='line' id='LC123'>		<span class="p">}</span></div><div class='line' id='LC124'>		<span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">aoDrawCallback</span><span class="p">.</span><span class="nx">push</span><span class="p">(</span> <span class="p">{</span></div><div class='line' id='LC125'>			<span class="nx">name</span><span class="o">:</span> <span class="s1">&#39;ColumnFilterWidgets&#39;</span><span class="p">,</span></div><div class='line' id='LC126'>			<span class="nx">fn</span><span class="o">:</span> <span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC127'>				<span class="nx">$</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span> <span class="nx">me</span><span class="p">.</span><span class="nx">aoWidgets</span><span class="p">,</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">i</span><span class="p">,</span> <span class="nx">oWidget</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC128'>					<span class="nx">oWidget</span><span class="p">.</span><span class="nx">fnDraw</span><span class="p">();</span></div><div class='line' id='LC129'>				<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC130'>			<span class="p">}</span></div><div class='line' id='LC131'>		<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC132'><br/></div><div class='line' id='LC133'>		<span class="k">return</span> <span class="nx">me</span><span class="p">;</span></div><div class='line' id='LC134'>	<span class="p">};</span></div><div class='line' id='LC135'><br/></div><div class='line' id='LC136'>	<span class="cm">/**</span></div><div class='line' id='LC137'><span class="cm">	* Get the container node of the column filter widgets.</span></div><div class='line' id='LC138'><span class="cm">	* </span></div><div class='line' id='LC139'><span class="cm">	* @method</span></div><div class='line' id='LC140'><span class="cm">	* @return {Node} The container node.</span></div><div class='line' id='LC141'><span class="cm">	*/</span></div><div class='line' id='LC142'>	<span class="nx">ColumnFilterWidgets</span><span class="p">.</span><span class="nx">prototype</span><span class="p">.</span><span class="nx">getContainer</span> <span class="o">=</span> <span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC143'>		<span class="k">return</span> <span class="k">this</span><span class="p">.</span><span class="nx">$WidgetContainer</span><span class="p">.</span><span class="nx">get</span><span class="p">(</span> <span class="mi">0</span> <span class="p">);</span></div><div class='line' id='LC144'>	<span class="p">}</span></div><div class='line' id='LC145'><br/></div><div class='line' id='LC146'>	<span class="cm">/**</span></div><div class='line' id='LC147'><span class="cm">	* A filter widget based on data in a table column.</span></div><div class='line' id='LC148'><span class="cm">	* </span></div><div class='line' id='LC149'><span class="cm">	* @class ColumnFilterWidget</span></div><div class='line' id='LC150'><span class="cm">	* @constructor</span></div><div class='line' id='LC151'><span class="cm">	* @param {object} $Container The jQuery object that should contain the widget.</span></div><div class='line' id='LC152'><span class="cm">	* @param {object} oSettings The target table&#39;s settings.</span></div><div class='line' id='LC153'><span class="cm">	* @param {number} i The numeric index of the target table column.</span></div><div class='line' id='LC154'><span class="cm">	* @param {object} widgets The ColumnFilterWidgets instance the widget is a member of.</span></div><div class='line' id='LC155'><span class="cm">	*/</span></div><div class='line' id='LC156'>	<span class="kd">var</span> <span class="nx">ColumnFilterWidget</span> <span class="o">=</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">$Container</span><span class="p">,</span> <span class="nx">oDataTableSettings</span><span class="p">,</span> <span class="nx">i</span><span class="p">,</span> <span class="nx">widgets</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC157'>		<span class="kd">var</span> <span class="nx">widget</span> <span class="o">=</span> <span class="k">this</span><span class="p">,</span> <span class="nx">sTargetList</span><span class="p">;</span></div><div class='line' id='LC158'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">iColumn</span> <span class="o">=</span> <span class="nx">i</span><span class="p">;</span></div><div class='line' id='LC159'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">oColumn</span> <span class="o">=</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">aoColumns</span><span class="p">[</span><span class="nx">i</span><span class="p">];</span></div><div class='line' id='LC160'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">$Container</span> <span class="o">=</span> <span class="nx">$Container</span><span class="p">;</span></div><div class='line' id='LC161'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">oDataTable</span> <span class="o">=</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInstance</span><span class="p">;</span></div><div class='line' id='LC162'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">asFilters</span> <span class="o">=</span> <span class="p">[];</span></div><div class='line' id='LC163'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">sSeparator</span> <span class="o">=</span> <span class="s1">&#39;&#39;</span><span class="p">;</span></div><div class='line' id='LC164'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">bSort</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC165'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">iMaxSelections</span> <span class="o">=</span> <span class="o">-</span><span class="mi">1</span><span class="p">;</span></div><div class='line' id='LC166'>		<span class="k">if</span> <span class="p">(</span> <span class="s1">&#39;oColumnFilterWidgets&#39;</span> <span class="k">in</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC167'>			<span class="k">if</span> <span class="p">(</span> <span class="s1">&#39;sSeparator&#39;</span> <span class="k">in</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC168'>				<span class="nx">widget</span><span class="p">.</span><span class="nx">sSeparator</span> <span class="o">=</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span><span class="p">.</span><span class="nx">sSeparator</span><span class="p">;</span></div><div class='line' id='LC169'>			<span class="p">}</span></div><div class='line' id='LC170'>			<span class="k">if</span> <span class="p">(</span> <span class="s1">&#39;iMaxSelections&#39;</span> <span class="k">in</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC171'>				<span class="nx">widget</span><span class="p">.</span><span class="nx">iMaxSelections</span> <span class="o">=</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span><span class="p">.</span><span class="nx">iMaxSelections</span><span class="p">;</span></div><div class='line' id='LC172'>			<span class="p">}</span></div><div class='line' id='LC173'>			<span class="k">if</span> <span class="p">(</span> <span class="s1">&#39;aoColumnDefs&#39;</span> <span class="k">in</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC174'>				<span class="nx">$</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span> <span class="nx">oDataTableSettings</span><span class="p">.</span><span class="nx">oInit</span><span class="p">.</span><span class="nx">oColumnFilterWidgets</span><span class="p">.</span><span class="nx">aoColumnDefs</span><span class="p">,</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">iIndex</span><span class="p">,</span> <span class="nx">oColumnDef</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC175'>					<span class="kd">var</span> <span class="nx">sTargetList</span> <span class="o">=</span> <span class="s1">&#39;|&#39;</span> <span class="o">+</span> <span class="nx">oColumnDef</span><span class="p">.</span><span class="nx">aiTargets</span><span class="p">.</span><span class="nx">join</span><span class="p">(</span> <span class="s1">&#39;|&#39;</span> <span class="p">)</span> <span class="o">+</span> <span class="s1">&#39;|&#39;</span><span class="p">;</span></div><div class='line' id='LC176'>					<span class="k">if</span> <span class="p">(</span> <span class="nx">sTargetList</span><span class="p">.</span><span class="nx">indexOf</span><span class="p">(</span> <span class="s1">&#39;|&#39;</span> <span class="o">+</span> <span class="nx">i</span> <span class="o">+</span> <span class="s1">&#39;|&#39;</span> <span class="p">)</span> <span class="o">&gt;=</span> <span class="mi">0</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC177'>						<span class="nx">$</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span> <span class="nx">oColumnDef</span><span class="p">,</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">sDef</span><span class="p">,</span> <span class="nx">oDef</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC178'>							<span class="nx">widget</span><span class="p">[</span><span class="nx">sDef</span><span class="p">]</span> <span class="o">=</span> <span class="nx">oDef</span><span class="p">;</span></div><div class='line' id='LC179'>						<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC180'>					<span class="p">}</span></div><div class='line' id='LC181'>				<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC182'>			<span class="p">}</span></div><div class='line' id='LC183'>		<span class="p">}</span></div><div class='line' id='LC184'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;select&gt;&lt;/select&gt;&#39;</span> <span class="p">).</span><span class="nx">change</span><span class="p">(</span> <span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC185'>			<span class="kd">var</span> <span class="nx">sSelected</span> <span class="o">=</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">val</span><span class="p">(),</span> <span class="nx">sText</span><span class="p">,</span> <span class="nx">$TermLink</span><span class="p">,</span> <span class="nx">$SelectedOption</span><span class="p">;</span> </div><div class='line' id='LC186'>			<span class="k">if</span> <span class="p">(</span> <span class="s1">&#39;&#39;</span> <span class="o">===</span> <span class="nx">sSelected</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC187'>				<span class="c1">// The blank option is a default, not a filter, and is re-selected after filtering</span></div><div class='line' id='LC188'>				<span class="k">return</span><span class="p">;</span></div><div class='line' id='LC189'>			<span class="p">}</span></div><div class='line' id='LC190'>			<span class="nx">sText</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;div&gt;&#39;</span> <span class="o">+</span> <span class="nx">sSelected</span> <span class="o">+</span> <span class="s1">&#39;&lt;/div&gt;&#39;</span> <span class="p">).</span><span class="nx">text</span><span class="p">();</span></div><div class='line' id='LC191'>			<span class="nx">$TermLink</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;a class=&quot;filter-term&quot; href=&quot;#&quot;&gt;&lt;/a&gt;&#39;</span> <span class="p">)</span></div><div class='line' id='LC192'>				<span class="p">.</span><span class="nx">addClass</span><span class="p">(</span> <span class="s1">&#39;filter-term-&#39;</span> <span class="o">+</span> <span class="nx">sText</span><span class="p">.</span><span class="nx">toLowerCase</span><span class="p">().</span><span class="nx">replace</span><span class="p">(</span> <span class="sr">/\W/g</span><span class="p">,</span> <span class="s1">&#39;&#39;</span> <span class="p">)</span> <span class="p">)</span></div><div class='line' id='LC193'>				<span class="p">.</span><span class="nx">text</span><span class="p">(</span> <span class="nx">sText</span> <span class="p">)</span></div><div class='line' id='LC194'>				<span class="p">.</span><span class="nx">click</span><span class="p">(</span> <span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC195'>					<span class="c1">// Remove from current filters array</span></div><div class='line' id='LC196'>					<span class="nx">widget</span><span class="p">.</span><span class="nx">asFilters</span> <span class="o">=</span> <span class="nx">$</span><span class="p">.</span><span class="nx">grep</span><span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">asFilters</span><span class="p">,</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">sFilter</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC197'>						<span class="k">return</span> <span class="nx">sFilter</span> <span class="o">!=</span> <span class="nx">sSelected</span><span class="p">;</span></div><div class='line' id='LC198'>					<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC199'>					<span class="nx">$TermLink</span><span class="p">.</span><span class="nx">remove</span><span class="p">();</span></div><div class='line' id='LC200'>					<span class="k">if</span> <span class="p">(</span> <span class="nx">widgets</span><span class="p">.</span><span class="nx">$TermContainer</span> <span class="o">&amp;&amp;</span> <span class="mi">0</span> <span class="o">===</span> <span class="nx">widgets</span><span class="p">.</span><span class="nx">$TermContainer</span><span class="p">.</span><span class="nx">find</span><span class="p">(</span> <span class="s1">&#39;.filter-term&#39;</span> <span class="p">).</span><span class="nx">length</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC201'>						<span class="nx">widgets</span><span class="p">.</span><span class="nx">$TermContainer</span><span class="p">.</span><span class="nx">hide</span><span class="p">();</span></div><div class='line' id='LC202'>					<span class="p">}</span></div><div class='line' id='LC203'>					<span class="c1">// Add it back to the select</span></div><div class='line' id='LC204'>					<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">append</span><span class="p">(</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;option&gt;&lt;/option&gt;&#39;</span> <span class="p">).</span><span class="nx">attr</span><span class="p">(</span> <span class="s1">&#39;value&#39;</span><span class="p">,</span> <span class="nx">sSelected</span> <span class="p">).</span><span class="nx">text</span><span class="p">(</span> <span class="nx">sText</span> <span class="p">)</span> <span class="p">);</span></div><div class='line' id='LC205'>					<span class="k">if</span> <span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">iMaxSelections</span> <span class="o">&gt;</span> <span class="mi">0</span> <span class="o">&amp;&amp;</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">iMaxSelections</span> <span class="o">&gt;</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">asFilters</span><span class="p">.</span><span class="nx">length</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC206'>						<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">attr</span><span class="p">(</span> <span class="s1">&#39;disabled&#39;</span><span class="p">,</span> <span class="kc">false</span> <span class="p">);</span></div><div class='line' id='LC207'>					<span class="p">}</span></div><div class='line' id='LC208'>					<span class="nx">widget</span><span class="p">.</span><span class="nx">fnFilter</span><span class="p">();</span></div><div class='line' id='LC209'>					<span class="k">return</span> <span class="kc">false</span><span class="p">;</span></div><div class='line' id='LC210'>				<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC211'>			<span class="nx">widget</span><span class="p">.</span><span class="nx">asFilters</span><span class="p">.</span><span class="nx">push</span><span class="p">(</span> <span class="nx">sSelected</span> <span class="p">);</span></div><div class='line' id='LC212'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">widgets</span><span class="p">.</span><span class="nx">$TermContainer</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC213'>				<span class="nx">widgets</span><span class="p">.</span><span class="nx">$TermContainer</span><span class="p">.</span><span class="nx">show</span><span class="p">();</span></div><div class='line' id='LC214'>				<span class="nx">widgets</span><span class="p">.</span><span class="nx">$TermContainer</span><span class="p">.</span><span class="nx">prepend</span><span class="p">(</span> <span class="nx">$TermLink</span> <span class="p">);</span></div><div class='line' id='LC215'>			<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC216'>				<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">after</span><span class="p">(</span> <span class="nx">$TermLink</span> <span class="p">);</span></div><div class='line' id='LC217'>			<span class="p">}</span></div><div class='line' id='LC218'>			<span class="nx">$SelectedOption</span> <span class="o">=</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">children</span><span class="p">(</span> <span class="s1">&#39;option:selected&#39;</span> <span class="p">);</span></div><div class='line' id='LC219'>			<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">val</span><span class="p">(</span> <span class="s1">&#39;&#39;</span> <span class="p">);</span></div><div class='line' id='LC220'>			<span class="nx">$SelectedOption</span><span class="p">.</span><span class="nx">remove</span><span class="p">();</span></div><div class='line' id='LC221'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">iMaxSelections</span> <span class="o">&gt;</span> <span class="mi">0</span> <span class="o">&amp;&amp;</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">iMaxSelections</span> <span class="o">&lt;=</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">asFilters</span><span class="p">.</span><span class="nx">length</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC222'>				<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">attr</span><span class="p">(</span> <span class="s1">&#39;disabled&#39;</span><span class="p">,</span> <span class="kc">true</span> <span class="p">);</span></div><div class='line' id='LC223'>			<span class="p">}</span></div><div class='line' id='LC224'>			<span class="nx">widget</span><span class="p">.</span><span class="nx">fnFilter</span><span class="p">();</span></div><div class='line' id='LC225'>		<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC226'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">$Container</span><span class="p">.</span><span class="nx">append</span><span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span> <span class="p">);</span></div><div class='line' id='LC227'>		<span class="nx">widget</span><span class="p">.</span><span class="nx">fnDraw</span><span class="p">();</span></div><div class='line' id='LC228'>	<span class="p">};</span></div><div class='line' id='LC229'><br/></div><div class='line' id='LC230'>	<span class="cm">/**</span></div><div class='line' id='LC231'><span class="cm">	* Perform filtering on the target column.</span></div><div class='line' id='LC232'><span class="cm">	* </span></div><div class='line' id='LC233'><span class="cm">	* @method fnFilter</span></div><div class='line' id='LC234'><span class="cm">	*/</span></div><div class='line' id='LC235'>	<span class="nx">ColumnFilterWidget</span><span class="p">.</span><span class="nx">prototype</span><span class="p">.</span><span class="nx">fnFilter</span> <span class="o">=</span> <span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC236'>		<span class="kd">var</span> <span class="nx">widget</span> <span class="o">=</span> <span class="k">this</span><span class="p">;</span></div><div class='line' id='LC237'>		<span class="kd">var</span> <span class="nx">asEscapedFilters</span> <span class="o">=</span> <span class="p">[];</span></div><div class='line' id='LC238'>		<span class="kd">var</span> <span class="nx">sFilterStart</span><span class="p">,</span> <span class="nx">sFilterEnd</span><span class="p">;</span></div><div class='line' id='LC239'>		<span class="k">if</span> <span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">asFilters</span><span class="p">.</span><span class="nx">length</span> <span class="o">&gt;</span> <span class="mi">0</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC240'>			<span class="c1">// Filters must have RegExp symbols escaped</span></div><div class='line' id='LC241'>			<span class="nx">$</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">asFilters</span><span class="p">,</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">i</span><span class="p">,</span> <span class="nx">sFilter</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC242'>				<span class="nx">asEscapedFilters</span><span class="p">.</span><span class="nx">push</span><span class="p">(</span> <span class="nx">fnRegExpEscape</span><span class="p">(</span> <span class="nx">sFilter</span> <span class="p">)</span> <span class="p">);</span></div><div class='line' id='LC243'>			<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC244'>			<span class="c1">// This regular expression filters by either whole column values or an item in a comma list</span></div><div class='line' id='LC245'>			<span class="nx">sFilterStart</span> <span class="o">=</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">sSeparator</span> <span class="o">?</span> <span class="s1">&#39;(^|&#39;</span> <span class="o">+</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">sSeparator</span> <span class="o">+</span> <span class="s1">&#39;)(&#39;</span> <span class="o">:</span> <span class="s1">&#39;^(&#39;</span><span class="p">;</span></div><div class='line' id='LC246'>			<span class="nx">sFilterEnd</span> <span class="o">=</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">sSeparator</span> <span class="o">?</span> <span class="s1">&#39;)(&#39;</span> <span class="o">+</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">sSeparator</span> <span class="o">+</span> <span class="s1">&#39;|$)&#39;</span> <span class="o">:</span> <span class="s1">&#39;)$&#39;</span><span class="p">;</span></div><div class='line' id='LC247'>			<span class="nx">widget</span><span class="p">.</span><span class="nx">oDataTable</span><span class="p">.</span><span class="nx">fnFilter</span><span class="p">(</span> <span class="nx">sFilterStart</span> <span class="o">+</span> <span class="nx">asEscapedFilters</span><span class="p">.</span><span class="nx">join</span><span class="p">(</span><span class="s1">&#39;|&#39;</span><span class="p">)</span> <span class="o">+</span> <span class="nx">sFilterEnd</span><span class="p">,</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">iColumn</span><span class="p">,</span> <span class="kc">true</span><span class="p">,</span> <span class="kc">false</span> <span class="p">);</span></div><div class='line' id='LC248'>		<span class="p">}</span> <span class="k">else</span> <span class="p">{</span> </div><div class='line' id='LC249'>			<span class="c1">// Clear any filters for this column</span></div><div class='line' id='LC250'>			<span class="nx">widget</span><span class="p">.</span><span class="nx">oDataTable</span><span class="p">.</span><span class="nx">fnFilter</span><span class="p">(</span> <span class="s1">&#39;&#39;</span><span class="p">,</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">iColumn</span> <span class="p">);</span></div><div class='line' id='LC251'>		<span class="p">}</span></div><div class='line' id='LC252'>	<span class="p">};</span></div><div class='line' id='LC253'><br/></div><div class='line' id='LC254'>	<span class="cm">/**</span></div><div class='line' id='LC255'><span class="cm">	* On each table draw, update filter menu items as needed. This allows any process to</span></div><div class='line' id='LC256'><span class="cm">	* update the table&#39;s column visiblity and menus will still be accurate.</span></div><div class='line' id='LC257'><span class="cm">	* </span></div><div class='line' id='LC258'><span class="cm">	* @method fnDraw</span></div><div class='line' id='LC259'><span class="cm">	*/</span></div><div class='line' id='LC260'>	<span class="nx">ColumnFilterWidget</span><span class="p">.</span><span class="nx">prototype</span><span class="p">.</span><span class="nx">fnDraw</span> <span class="o">=</span> <span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC261'>		<span class="kd">var</span> <span class="nx">widget</span> <span class="o">=</span> <span class="k">this</span><span class="p">;</span></div><div class='line' id='LC262'>		<span class="kd">var</span> <span class="nx">oDistinctOptions</span> <span class="o">=</span> <span class="p">{};</span></div><div class='line' id='LC263'>		<span class="kd">var</span> <span class="nx">aDistinctOptions</span> <span class="o">=</span> <span class="p">[];</span></div><div class='line' id='LC264'>		<span class="kd">var</span> <span class="nx">aData</span><span class="p">;</span></div><div class='line' id='LC265'>		<span class="k">if</span> <span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">asFilters</span><span class="p">.</span><span class="nx">length</span> <span class="o">===</span> <span class="mi">0</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC266'>			<span class="c1">// Find distinct column values</span></div><div class='line' id='LC267'>			<span class="nx">aData</span> <span class="o">=</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">oDataTable</span><span class="p">.</span><span class="nx">fnGetColumnData</span><span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">iColumn</span> <span class="p">);</span></div><div class='line' id='LC268'>			<span class="nx">$</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span> <span class="nx">aData</span><span class="p">,</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">i</span><span class="p">,</span> <span class="nx">sValue</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC269'>				<span class="kd">var</span> <span class="nx">asValues</span> <span class="o">=</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">sSeparator</span> <span class="o">?</span> <span class="nx">sValue</span><span class="p">.</span><span class="nx">split</span><span class="p">(</span> <span class="k">new</span> <span class="nb">RegExp</span><span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">sSeparator</span> <span class="p">)</span> <span class="p">)</span> <span class="o">:</span> <span class="p">[</span> <span class="nx">sValue</span> <span class="p">];</span></div><div class='line' id='LC270'>				<span class="nx">$</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span> <span class="nx">asValues</span><span class="p">,</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">j</span><span class="p">,</span> <span class="nx">sOption</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC271'>					<span class="k">if</span> <span class="p">(</span> <span class="o">!</span><span class="nx">oDistinctOptions</span><span class="p">.</span><span class="nx">hasOwnProperty</span><span class="p">(</span> <span class="nx">sOption</span> <span class="p">)</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC272'>						<span class="nx">oDistinctOptions</span><span class="p">[</span><span class="nx">sOption</span><span class="p">]</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC273'>						<span class="nx">aDistinctOptions</span><span class="p">.</span><span class="nx">push</span><span class="p">(</span> <span class="nx">sOption</span> <span class="p">);</span></div><div class='line' id='LC274'>					<span class="p">}</span></div><div class='line' id='LC275'>				<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC276'>			<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC277'>			<span class="c1">// Build the menu</span></div><div class='line' id='LC278'>			<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">empty</span><span class="p">().</span><span class="nx">append</span><span class="p">(</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;option&gt;&lt;/option&gt;&#39;</span> <span class="p">).</span><span class="nx">attr</span><span class="p">(</span> <span class="s1">&#39;value&#39;</span><span class="p">,</span> <span class="s1">&#39;&#39;</span> <span class="p">).</span><span class="nx">text</span><span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">oColumn</span><span class="p">.</span><span class="nx">sTitle</span> <span class="p">)</span> <span class="p">);</span></div><div class='line' id='LC279'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">bSort</span> <span class="p">)</span> <span class="p">{</span> </div><div class='line' id='LC280'>				<span class="k">if</span> <span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">hasOwnProperty</span><span class="p">(</span> <span class="s1">&#39;fnSort&#39;</span> <span class="p">)</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC281'>					<span class="nx">aDistinctOptions</span><span class="p">.</span><span class="nx">sort</span><span class="p">(</span> <span class="nx">widget</span><span class="p">.</span><span class="nx">fnSort</span> <span class="p">);</span></div><div class='line' id='LC282'>				<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC283'>					<span class="nx">aDistinctOptions</span><span class="p">.</span><span class="nx">sort</span><span class="p">();</span></div><div class='line' id='LC284'>				<span class="p">}</span></div><div class='line' id='LC285'>			<span class="p">}</span></div><div class='line' id='LC286'>			<span class="nx">$</span><span class="p">.</span><span class="nx">each</span><span class="p">(</span> <span class="nx">aDistinctOptions</span><span class="p">,</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">i</span><span class="p">,</span> <span class="nx">sOption</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC287'>				<span class="kd">var</span> <span class="nx">sText</span><span class="p">;</span> </div><div class='line' id='LC288'>				<span class="nx">sText</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;div&gt;&#39;</span> <span class="o">+</span> <span class="nx">sOption</span> <span class="o">+</span> <span class="s1">&#39;&lt;/div&gt;&#39;</span> <span class="p">).</span><span class="nx">text</span><span class="p">();</span></div><div class='line' id='LC289'>				<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">append</span><span class="p">(</span> <span class="nx">$</span><span class="p">(</span> <span class="s1">&#39;&lt;option&gt;&lt;/option&gt;&#39;</span> <span class="p">).</span><span class="nx">attr</span><span class="p">(</span> <span class="s1">&#39;value&#39;</span><span class="p">,</span> <span class="nx">sOption</span> <span class="p">).</span><span class="nx">text</span><span class="p">(</span> <span class="nx">sText</span> <span class="p">)</span> <span class="p">);</span></div><div class='line' id='LC290'>			<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC291'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">aDistinctOptions</span><span class="p">.</span><span class="nx">length</span> <span class="o">&gt;</span> <span class="mi">1</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC292'>				<span class="c1">// Enable the menu </span></div><div class='line' id='LC293'>				<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">attr</span><span class="p">(</span> <span class="s1">&#39;disabled&#39;</span><span class="p">,</span> <span class="kc">false</span> <span class="p">);</span></div><div class='line' id='LC294'>			<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC295'>				<span class="c1">// One option is not a useful menu, disable it</span></div><div class='line' id='LC296'>				<span class="nx">widget</span><span class="p">.</span><span class="nx">$Select</span><span class="p">.</span><span class="nx">attr</span><span class="p">(</span> <span class="s1">&#39;disabled&#39;</span><span class="p">,</span> <span class="kc">true</span> <span class="p">);</span></div><div class='line' id='LC297'>			<span class="p">}</span></div><div class='line' id='LC298'>		<span class="p">}</span></div><div class='line' id='LC299'>	<span class="p">};</span></div><div class='line' id='LC300'><br/></div><div class='line' id='LC301'>	<span class="cm">/*</span></div><div class='line' id='LC302'><span class="cm">	 * Register a new feature with DataTables</span></div><div class='line' id='LC303'><span class="cm">	 */</span></div><div class='line' id='LC304'>	<span class="k">if</span> <span class="p">(</span> <span class="k">typeof</span> <span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">dataTable</span> <span class="o">===</span> <span class="s1">&#39;function&#39;</span> <span class="o">&amp;&amp;</span> <span class="k">typeof</span> <span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">dataTableExt</span><span class="p">.</span><span class="nx">fnVersionCheck</span> <span class="o">===</span> <span class="s1">&#39;function&#39;</span> <span class="o">&amp;&amp;</span> <span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">dataTableExt</span><span class="p">.</span><span class="nx">fnVersionCheck</span><span class="p">(</span><span class="s1">&#39;1.7.0&#39;</span><span class="p">)</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC305'><br/></div><div class='line' id='LC306'>		<span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">dataTableExt</span><span class="p">.</span><span class="nx">aoFeatures</span><span class="p">.</span><span class="nx">push</span><span class="p">(</span> <span class="p">{</span></div><div class='line' id='LC307'>			<span class="s1">&#39;fnInit&#39;</span><span class="o">:</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">oDTSettings</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC308'>				<span class="kd">var</span> <span class="nx">oWidgets</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">ColumnFilterWidgets</span><span class="p">(</span> <span class="nx">oDTSettings</span> <span class="p">);</span></div><div class='line' id='LC309'>				<span class="k">return</span> <span class="nx">oWidgets</span><span class="p">.</span><span class="nx">getContainer</span><span class="p">();</span></div><div class='line' id='LC310'>			<span class="p">},</span></div><div class='line' id='LC311'>			<span class="s1">&#39;cFeature&#39;</span><span class="o">:</span> <span class="s1">&#39;W&#39;</span><span class="p">,</span></div><div class='line' id='LC312'>			<span class="s1">&#39;sFeature&#39;</span><span class="o">:</span> <span class="s1">&#39;ColumnFilterWidgets&#39;</span></div><div class='line' id='LC313'>		<span class="p">}</span> <span class="p">);</span></div><div class='line' id='LC314'><br/></div><div class='line' id='LC315'>	<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC316'>		<span class="k">throw</span> <span class="s1">&#39;Warning: ColumnFilterWidgets requires DataTables 1.7 or greater - www.datatables.net/download&#39;</span><span class="p">;</span></div><div class='line' id='LC317'>	<span class="p">}</span></div><div class='line' id='LC318'><br/></div><div class='line' id='LC319'><br/></div><div class='line' id='LC320'><span class="p">}(</span><span class="nx">jQuery</span><span class="p">));</span></div></pre></div>
          </td>
        </tr>
      </table>
  </div>

          </div>
        </div>
      </div>
    </div>

  </div>

<div class="frame frame-loading large-loading-area" style="display:none;" data-tree-list-url="/cyberhobo/ColumnFilterWidgets/tree-list/c1bb020583ac0fccf04425cbaa7713b6070aa6ca" data-blob-url-prefix="/cyberhobo/ColumnFilterWidgets/blob/c1bb020583ac0fccf04425cbaa7713b6070aa6ca">
  <img src="https://a248.e.akamai.net/assets.github.com/images/spinners/octocat-spinner-128.gif?1347543527" height="64" width="64">
</div>

        </div>
      </div>
      <div class="context-overlay"></div>
    </div>

      <div id="footer-push"></div><!-- hack for sticky footer -->
    </div><!-- end of wrapper - hack for sticky footer -->

      <!-- footer -->
      <div id="footer" >
        
  <div class="upper_footer">
     <div class="container clearfix">

       <!--[if IE]><h4 id="blacktocat_ie">GitHub Links</h4><![endif]-->
       <![if !IE]><h4 id="blacktocat">GitHub Links</h4><![endif]>

       <ul class="footer_nav">
         <h4>GitHub</h4>
         <li><a href="https://github.com/about">About</a></li>
         <li><a href="https://github.com/blog">Blog</a></li>
         <li><a href="https://github.com/features">Features</a></li>
         <li><a href="https://github.com/contact">Contact &amp; Support</a></li>
         <li><a href="https://github.com/training">Training</a></li>
         <li><a href="http://enterprise.github.com/">GitHub Enterprise</a></li>
         <li><a href="http://status.github.com/">Site Status</a></li>
       </ul>

       <ul class="footer_nav">
         <h4>Clients</h4>
         <li><a href="http://mac.github.com/">GitHub for Mac</a></li>
         <li><a href="http://windows.github.com/">GitHub for Windows</a></li>
         <li><a href="http://eclipse.github.com/">GitHub for Eclipse</a></li>
         <li><a href="http://mobile.github.com/">GitHub Mobile Apps</a></li>
       </ul>

       <ul class="footer_nav">
         <h4>Tools</h4>
         <li><a href="http://get.gaug.es/">Gauges: Web analytics</a></li>
         <li><a href="http://speakerdeck.com">Speaker Deck: Presentations</a></li>
         <li><a href="https://gist.github.com">Gist: Code snippets</a></li>

         <h4 class="second">Extras</h4>
         <li><a href="http://jobs.github.com/">Job Board</a></li>
         <li><a href="http://shop.github.com/">GitHub Shop</a></li>
         <li><a href="http://octodex.github.com/">The Octodex</a></li>
       </ul>

       <ul class="footer_nav">
         <h4>Documentation</h4>
         <li><a href="http://help.github.com/">GitHub Help</a></li>
         <li><a href="http://developer.github.com/">Developer API</a></li>
         <li><a href="http://github.github.com/github-flavored-markdown/">GitHub Flavored Markdown</a></li>
         <li><a href="http://pages.github.com/">GitHub Pages</a></li>
       </ul>

     </div><!-- /.site -->
  </div><!-- /.upper_footer -->

<div class="lower_footer">
  <div class="container clearfix">
    <!--[if IE]><div id="legal_ie"><![endif]-->
    <![if !IE]><div id="legal"><![endif]>
      <ul>
          <li><a href="https://github.com/site/terms">Terms of Service</a></li>
          <li><a href="https://github.com/site/privacy">Privacy</a></li>
          <li><a href="https://github.com/security">Security</a></li>
      </ul>

      <p>&copy; 2012 <span title="0.15011s from fe2.rs.github.com">GitHub</span> Inc. All rights reserved.</p>
    </div><!-- /#legal or /#legal_ie-->

  </div><!-- /.site -->
</div><!-- /.lower_footer -->

      </div><!-- /#footer -->

    

<div id="keyboard_shortcuts_pane" class="instapaper_ignore readability-extra" style="display:none">
  <h2>Keyboard Shortcuts <small><a href="#" class="js-see-all-keyboard-shortcuts">(see all)</a></small></h2>

  <div class="columns threecols">
    <div class="column first">
      <h3>Site wide shortcuts</h3>
      <dl class="keyboard-mappings">
        <dt>s</dt>
        <dd>Focus site search</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>?</dt>
        <dd>Bring up this help dialog</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column middle" style='display:none'>
      <h3>Commit list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selection down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selection up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>c <em>or</em> o <em>or</em> enter</dt>
        <dd>Open commit</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>y</dt>
        <dd>Expand URL to its canonical form</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column last js-hidden-pane" style='display:none'>
      <h3>Pull request list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selection down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selection up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>o <em>or</em> enter</dt>
        <dd>Open issue</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt><span class="platform-mac">⌘</span><span class="platform-other">ctrl</span> <em>+</em> enter</dt>
        <dd>Submit comment</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt><span class="platform-mac">⌘</span><span class="platform-other">ctrl</span> <em>+</em> shift p</dt>
        <dd>Preview comment</dd>
      </dl>
    </div><!-- /.columns.last -->

  </div><!-- /.columns.equacols -->

  <div class="js-hidden-pane" style='display:none'>
    <div class="rule"></div>

    <h3>Issues</h3>

    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>j</dt>
          <dd>Move selection down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>k</dt>
          <dd>Move selection up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>x</dt>
          <dd>Toggle selection</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o <em>or</em> enter</dt>
          <dd>Open issue</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="platform-mac">⌘</span><span class="platform-other">ctrl</span> <em>+</em> enter</dt>
          <dd>Submit comment</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="platform-mac">⌘</span><span class="platform-other">ctrl</span> <em>+</em> shift p</dt>
          <dd>Preview comment</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>c</dt>
          <dd>Create issue</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Create label</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>i</dt>
          <dd>Back to inbox</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>u</dt>
          <dd>Back to issues</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>/</dt>
          <dd>Focus issues search</dd>
        </dl>
      </div>
    </div>
  </div>

  <div class="js-hidden-pane" style='display:none'>
    <div class="rule"></div>

    <h3>Issues Dashboard</h3>

    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>j</dt>
          <dd>Move selection down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>k</dt>
          <dd>Move selection up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o <em>or</em> enter</dt>
          <dd>Open issue</dd>
        </dl>
      </div><!-- /.column.first -->
    </div>
  </div>

  <div class="js-hidden-pane" style='display:none'>
    <div class="rule"></div>

    <h3>Network Graph</h3>
    <div class="columns equacols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt><span class="badmono">←</span> <em>or</em> h</dt>
          <dd>Scroll left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">→</span> <em>or</em> l</dt>
          <dd>Scroll right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↑</span> <em>or</em> k</dt>
          <dd>Scroll up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↓</span> <em>or</em> j</dt>
          <dd>Scroll down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Toggle visibility of head labels</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">←</span> <em>or</em> shift h</dt>
          <dd>Scroll all the way left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">→</span> <em>or</em> shift l</dt>
          <dd>Scroll all the way right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↑</span> <em>or</em> shift k</dt>
          <dd>Scroll all the way up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↓</span> <em>or</em> shift j</dt>
          <dd>Scroll all the way down</dd>
        </dl>
      </div><!-- /.column.last -->
    </div>
  </div>

  <div class="js-hidden-pane" >
    <div class="rule"></div>
    <div class="columns threecols">
      <div class="column first js-hidden-pane" >
        <h3>Source Code Browsing</h3>
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Activates the file finder</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Jump to line</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>w</dt>
          <dd>Switch branch/tag</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>y</dt>
          <dd>Expand URL to its canonical form</dd>
        </dl>
      </div>
    </div>
  </div>

  <div class="js-hidden-pane" style='display:none'>
    <div class="rule"></div>
    <div class="columns threecols">
      <div class="column first">
        <h3>Browsing Commits</h3>
        <dl class="keyboard-mappings">
          <dt><span class="platform-mac">⌘</span><span class="platform-other">ctrl</span> <em>+</em> enter</dt>
          <dd>Submit comment</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>escape</dt>
          <dd>Close form</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>p</dt>
          <dd>Parent commit</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o</dt>
          <dd>Other parent commit</dd>
        </dl>
      </div>
    </div>
  </div>

  <div class="js-hidden-pane" style='display:none'>
    <div class="rule"></div>
    <h3>Notifications</h3>

    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>j</dt>
          <dd>Move selection down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>k</dt>
          <dd>Move selection up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o <em>or</em> enter</dt>
          <dd>Open notification</dd>
        </dl>
      </div><!-- /.column.first -->

      <div class="column second">
        <dl class="keyboard-mappings">
          <dt>e <em>or</em> shift i <em>or</em> y</dt>
          <dd>Mark as read</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift m</dt>
          <dd>Mute thread</dd>
        </dl>
      </div><!-- /.column.first -->
    </div>
  </div>

</div>

    <div id="markdown-help" class="instapaper_ignore readability-extra">
  <h2>Markdown Cheat Sheet</h2>

  <div class="cheatsheet-content">

  <div class="mod">
    <div class="col">
      <h3>Format Text</h3>
      <p>Headers</p>
      <pre>
# This is an &lt;h1&gt; tag
## This is an &lt;h2&gt; tag
###### This is an &lt;h6&gt; tag</pre>
     <p>Text styles</p>
     <pre>
*This text will be italic*
_This will also be italic_
**This text will be bold**
__This will also be bold__

*You **can** combine them*
</pre>
    </div>
    <div class="col">
      <h3>Lists</h3>
      <p>Unordered</p>
      <pre>
* Item 1
* Item 2
  * Item 2a
  * Item 2b</pre>
     <p>Ordered</p>
     <pre>
1. Item 1
2. Item 2
3. Item 3
   * Item 3a
   * Item 3b</pre>
    </div>
    <div class="col">
      <h3>Miscellaneous</h3>
      <p>Images</p>
      <pre>
![GitHub Logo](/images/logo.png)
Format: ![Alt Text](url)
</pre>
     <p>Links</p>
     <pre>
http://github.com - automatic!
[GitHub](http://github.com)</pre>
<p>Blockquotes</p>
     <pre>
As Kanye West said:

> We're living the future so
> the present is our past.
</pre>
    </div>
  </div>
  <div class="rule"></div>

  <h3>Code Examples in Markdown</h3>
  <div class="col">
      <p>Syntax highlighting with <a href="http://github.github.com/github-flavored-markdown/" title="GitHub Flavored Markdown" target="_blank">GFM</a></p>
      <pre>
```javascript
function fancyAlert(arg) {
  if(arg) {
    $.facebox({div:'#foo'})
  }
}
```</pre>
    </div>
    <div class="col">
      <p>Or, indent your code 4 spaces</p>
      <pre>
Here is a Python code example
without syntax highlighting:

    def foo:
      if not bar:
        return true</pre>
    </div>
    <div class="col">
      <p>Inline code for comments</p>
      <pre>
I think you should use an
`&lt;addr&gt;` element here instead.</pre>
    </div>
  </div>

  </div>
</div>


    <div id="ajax-error-message" class="flash flash-error">
      <span class="mini-icon mini-icon-exclamation"></span>
      Something went wrong with that request. Please try again.
      <a href="#" class="mini-icon mini-icon-remove-close ajax-error-dismiss"></a>
    </div>

    <div id="logo-popup">
      <h2>Looking for the GitHub logo?</h2>
      <ul>
        <li>
          <h4>GitHub Logo</h4>
          <a href="http://github-media-downloads.s3.amazonaws.com/GitHub_Logos.zip"><img alt="Github_logo" src="https://a248.e.akamai.net/assets.github.com/images/modules/about_page/github_logo.png?1338945074" /></a>
          <a href="http://github-media-downloads.s3.amazonaws.com/GitHub_Logos.zip" class="minibutton download">Download</a>
        </li>
        <li>
          <h4>The Octocat</h4>
          <a href="http://github-media-downloads.s3.amazonaws.com/Octocats.zip"><img alt="Octocat" src="https://a248.e.akamai.net/assets.github.com/images/modules/about_page/octocat.png?1338945074" /></a>
          <a href="http://github-media-downloads.s3.amazonaws.com/Octocats.zip" class="minibutton download">Download</a>
        </li>
      </ul>
    </div>

    
    
    <span id='server_response_time' data-time='0.15707' data-host='fe2'></span>
    
  </body>
</html>

