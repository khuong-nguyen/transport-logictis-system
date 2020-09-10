@extends('layout.app')
@section('title', 'Print Booking')
@section('content')
<link rel="stylesheet" href="/print_booking/style/style.css">

<style type="text/css" media="print">
    .noprint {
        display: none
    }
    
    .print {
        display: block !important;
    }
</style>
    <div id="app">
        <header class="el-header noprint">
            <div class="icon-btns">
                <i class="icon-list" @click="changeLeftMenu"></i>
                <i class="icon-skip_previous" v-bind:class="{'disabled': currentPage == 1}" @click="changeCurrentPage('first')"></i>
                <i class="icon-play_arrow prev-icon" v-bind:class="{'disabled': currentPage == 1}" @click="changeCurrentPage('prev')"></i>
                <i class="icon-play_arrow" v-bind:class="{'disabled': currentPage == pageNum}" @click="changeCurrentPage('next')"></i>
                <i class="icon-skip_next" v-bind:class="{'disabled': currentPage == pageNum}" @click="changeCurrentPage('last')"></i>
                <select v-model="currentPage">
                    <option v-for="page in pageNum" v-bind:value="page">page @{{ page }}</option>
                </select>
                <i class="icon-zoom_in" v-bind:class="{'disabled': zoomNum == 2}" @click="modifyZoom('in')"></i>
                <select v-model="zoomNum">
                    <option value="0.5">50%</option>
                    <option value="0.6">60%</option>
                    <option value="0.7">70%</option>
                    <option value="0.8">80%</option>
                    <option value="0.9">90%</option>
                    <option value="1.0" selected>100%</option>
                    <option value="1.1">110%</option>
                    <option value="1.2">120%</option>
                    <option value="1.3">130%</option>
                    <option value="1.4">140%</option>
                    <option value="1.5">150%</option>
                    <option value="1.6">160%</option>
                    <option value="1.7">170%</option>
                    <option value="1.8">180%</option>
                    <option value="1.9">190%</option>
                    <option value="2.0">200%</option>
                </select>
                <i class="icon-zoom_out" v-bind:class="{'disabled': zoomNum == 0.5}" @click="modifyZoom('out')"></i>
                <i class="icon-format_align_left" @click="textAlign = 'left'"></i>
                <i class="icon-format_align_center" @click="textAlign = 'center'"></i>
                <i class="icon-format_align_right" @click="textAlign = 'right'"></i>
                <i class="icon-print" @click="window.print()"></i>
            </div>
        </header>

        <aside class="noprint" width="240px" v-show="ifMenuShow">
            <nav class="tabNav">
                <ul>
                    <li v-bind:class="{ 'curr': currentNav == 0 }" @click="currentNav = 0">Page</li>
                    <li v-bind:class="{ 'curr': currentNav == 1 }" @click="currentNav = 1">Bookmark</li>
                </ul>

                <div class="clear"></div>
            </nav>

            <div class="tab-conent scrollbar" v-bind:style="{ height: asideHeight + 'px' }">

            <section v-show="currentNav == 0">
                <ul class="page-menu">
                    <li v-for="page in pageNum" v-bind:class="{ 'curr': currentPage == page }" @click="changePage(page)"><i class="icon-file-text2"></i> page @{{ page }}</li>
                </ul>
            </section>

            <section v-show="currentNav == 1">
                <ul class="page-menu">
                    <li v-for="page in pageNum" v-bind:class="{ 'curr': currentPage == page }" @click="changePage(page)"><i class="icon-turned_in_not"></i> Bookmark @{{page }}</li>
                </ul>
            </section>
        </div>

        </aside>
        <div class="main scrollbar noprint"  v-bind:style="{ height: mainHeight + 'px' }" v-bind:class="{ 'mainLeftM': ifMenuShow, 'aleft': textAlign === 'left','acenter': textAlign === 'center','aright': textAlign === 'right'}">
            <div class="conent" v-html="pageContent" v-bind:style="zoomStyle">
            </div>

            <div class="clear"></div>
        </div>

        <!--专门只为打印的内容-->
        <div class="conent print" style="display:none" v-html="pageContent">
        </div>
    	
    </div>
</body>
<!-- 先引入 Vue -->
<script src="/print_booking/js/vue.min.js"></script>
<script>
var app = new Vue({
        el: '#app',
        data: function() {
            return {
                // visible: false,
                isCollapse: false,
                currentNav: 0,
                activeName2: 'first',
                pageNum: 1, 
                currentPage: 1,
                pageContent: '',
                asideHeight: 300,
                mainHeight: 300,
                ifMenuShow: true,
                zoomNum: '1.0',
                textAlign: 'left',
                zoomStyle: {},
                pageDatas: [{!! $detail_booking !!}]
            }
        },
        mounted: function() {
            this.$nextTick(function() {
                this.pageNum = this.pageDatas.length;
                this.pageContent = this.pageDatas[0];

                this.setLeftMenuHeight();
            })
        },
        watch: {
            'currentPage': function(newVal, oldValue) {
                // console.log('newVal ' + newVal, 'oldValue ' + oldValue);
                if (newVal) {
                    this.pageContent = this.pageDatas[this.currentPage - 1];
                }
            },
            'zoomNum': function(newVal, oldValue) {
                if (newVal) {
                    this.zoomStyle = {
                        'transform': 'scale(' + newVal + ')',
                        '-webkit-transform': 'scale(' + newVal + ')',
                        '-ms-transform': 'scale(' + newVal + ')',
                        '-moz-transform': 'scale(' + newVal + ')',
                        '-o-transform': 'scale(' + newVal + ')'
                    }
                }
            }
        },
        methods: {
            
            changeCurrentPage: function(methods) {
                switch (methods) {
                    case 'first':
                        this.currentPage = 1;
                        break;
                    case 'prev':
                        if (this.currentPage > 1) {
                            this.currentPage -= 1;
                        }
                        break;
                    case 'next':
                        if (this.currentPage < this.pageNum) {
                            this.currentPage += 1;
                        }
                        break;
                    case 'last':
                        this.currentPage = this.pageNum;
                        break;
                }
            },

            gotoPage: function(page) {
                console.log(page);
                this.currentPage = page;
            },
            modifyZoom: function(type) {
                switch (type) {
                    case 'in':
                        if (this.zoomNum < 2) {
                            // this.zoomNum = (this.zoomNum + 0.1).toFixed(1);
                            this.zoomNum = (parseFloat(this.zoomNum) + 0.1).toFixed(1);
                        }
                        break;
                    case 'out':
                        if (this.zoomNum > 0.5) {
                            this.zoomNum = (parseFloat(this.zoomNum) - 0.1).toFixed(1);
                        }
                        break;
                    default:
                        break;
                }
                console.log(this.zoomNum);
            },
            setLeftMenuHeight: function() {
                // this.asideHeight = document.body.scrollHeight - 60;
                this.mainHeight = document.documentElement.clientHeight - 60 - 20;
                // 60为头部导航高度， 46为menu高度， 40为上下padding
                this.asideHeight = this.mainHeight - 20 - 46;
            },
            changePage: function(page) {
                this.currentPage = page;
                // this.pageContent = this.pageDatas[page - 1];
            },
            changeLeftMenu: function() {
                this.ifMenuShow = !this.ifMenuShow;
            }
        }
    });

function gotoPage(page) {
    console.log(page);
    app.gotoPage(page);
}

</script>

@endsection