jQuery(document).ready(function($){
	// 文字展开
	$(".showmore span").click(function(e){
		$(this).html(["▼展开", "▲收起"][this.hutia^=1]);
		$(this.parentNode.parentNode).next().slideToggle("fast","linear");
		e.preventDefault();
	});

    // 目录
    $(".log-button, .log-close").click(function() {
    $("#log-box").fadeToggle(300);
    });

    if ($("#log-box").length > 0) {
    $(".log").removeClass("log-no");
    }
    $('.log-prompt').show().delay(5000).fadeOut();

	//RSS 小工具链接新窗口打开
	$("a.rsswidget").attr('target', '_blank');

	// 取消回复清空评论框
	$(".comment-reply-title").click(function() { //点击取消回复评论清空评论框的内容
		document.getElementById('comment').value = '';
	});

	// 滚屏
	$('.scroll-t').click(function () {
		$('html,body').animate({
			scrollTop: '0px'
		});
	});
	$('.scroll-c').click(function () {
		$('html,body').animate({
			scrollTop: $('#respond').offset().top
	 	});
	});
	$('.scroll-b').click(function () {
		$('html,body').animate({
			scrollTop: $('.site-info').offset().top
		});
	});

	var id = "comment";
	var quoteArr = [
		'我始终记住：青春是美丽的东西，而且对我来说它永远是鼓舞的源泉。——巴金',
		'天下攘攘，皆為利往。天下熙熙，皆為利來。',
		'我之所谓生存，并不是苟活；所谓温饱，并不是奢侈；所谓发展，也不是放纵。 ——鲁迅',
		'知其雄，守其雌；知其白，守其黑；知其荣，守其辱。——老子',
		'君子惠而不费，劳而不怨，欲而不贪，泰而不骄，威而不猛。——尧曰',
		'君子食无求饱，居无求安，敏于事而慎于言。——学而',
		'藏焉，修焉，息焉，游焉。——礼记',
		'知人者智，自知者明。胜人者有力，自胜者强。知足者富。强行者有志。',
		'信言不美。美言不信。善者不辩。辩者不善。知者不博。博者不知。',
		'这辈子没法做太多的事情, 所以每一件都要做到精彩绝伦!——史蒂夫.乔布斯',
		'我每天都自问：“如果今天是我生命的最后一天, 我还会做今天打算做的事情吗？”——史蒂夫.乔布斯',
		'你若不想做, 总能找到借口；你若想做, 总会找到方法——阿拉伯谚语',
		'宁鸣而死 不默而生——范仲淹',
		'获得信任的技巧就是避免使用任何技巧',
		'判断一个人的人品, 不是看他好起来做什么好事, 而是看他坏起来【不做】什么坏事。',
		'不要去欺骗别人 -- 因为你能骗到的人, 都是相信你的人。',
		'授人以鱼不如授人以渔！授人以鱼只救一时之急, 授人以渔则可解一生之需。',
		'知识上的投资总能得到最好的回报。——本杰明.富兰克林',
		'读书是在别人思想的帮助下建立自己的思想——尼古拉.鲁巴金',
		'想象力比知识更重要! 因为知识是有限的, 而想象力概括着世界的一切, 推动着进步, 并且是知识进化的源泉。——爱因斯坦',
		'你要按你所想的去生活; 否则, 你迟早会按你所生活的去想!',
		'大多数人宁愿死去, 也不愿思考。 -- 事实上他们也确实到死都没有思考。——罗素',
		'你可以暂时地蒙骗所有人, 也可以永久地蒙骗部分人, 但不可能永久地蒙骗所有人。——林肯',
		'世上最难的两件事: 把自己的思想装进别人的脑袋, 把别人的钞票装进自己的口袋 -- XXX都做到了!',
		'以铜为镜, 可以正衣冠; 以史为镜, 可以知兴替; 以人为镜, 可以明得失。——李世民 (唐太宗)',
		'简单即是美 - Simple is beautiful',
		'控制风险的最好办法是深入思考, 而不是投资组合。——巴菲特',
		'价值投资不能保证我们盈利, 但价值投资给我们提供了通向成功的唯一机会。——巴菲特',
		'我从事投资时, 会观察一家公司的全貌; 而大多数投资人只盯着它的股价。——巴菲特',
		'退潮时, 便可知道谁在裸泳。——巴菲特',
		'投资的风险来自于: 你不知道你在做什么 :)——巴菲特',
		'以用户为中心, 其它一切纷至沓来!——Google 信条',
		'只有偏执狂才能生存!——Andy Grove (英特尔创始人之一, 前任CEO)',
		'领袖和跟风者的区别就在于创新!——史蒂夫.乔布斯',
		'我们没有不懂技术的管理人员 -- 因为寻求技术和管理的平衡毫不费力!——比尔.盖茨',
		'伟大的车工值得给他几倍于普通车工的薪水。但一个伟大的程序员, 其价值相当于普通程序员的1万倍!——比尔.盖茨',
		'唯一不变的是变化本身!',
		'一个人最好记性不要太好，因为回忆越多，幸福感越少。',
		'活得累是因为心里装了多余的东西，跟吃饱了撑的是一个道理。',
		'早起的鸟儿有虫吃；早起的虫儿被鸟吃。',
		'如果你手里有一把锤子，所有东西看上去都像钉子。',
		'Done is better than perfect.比完美更重要的是完成。',
		'如果你看对了生意模式，你就会赚很多钱。',
		'所谓成长，就是在听到波涛汹涌四个字，再也联想不到大海了。',
		'谢谢你，在我每次需要你的时候都掉链子',
		'先生，你这张卡上的钱也不够……',
		'喜欢就去表白，不然你不会知道自己长得多丑。',
		'所有抱怨社会不公和制度的人翻译过来只有一句话：请给我金钱，女人和社会地位。',
		'虽然我学得慢，但是我放弃的快啊！',
		'死并不可怕，怕的是再也不能活了。',
		'谁说我不会乐器？我退堂鼓打的可好了。',
		'世界这么大，我想去看看，什么地方要饭比较方便！',
		'诗和远方越远越脏 以梦为马越骑越傻！',
		'生活不止眼前的苟且，还有读不懂的诗和到不了的远方。',
		'上帝为你关上一道防盗门，还会顺手给你上了一把钛合金锁。',
		'如果所有人都理解你，那你得普通成什么样！',
		'如果十年之后你未娶，我未嫁，那真是太惨了！',
		'人生不如意，十之有十！',
		'人人都想拯救世界，却没人帮妈妈洗碗。',
		'其实只要不要脸，很多人生难题都能迎刃而解。',
		'你每天都那么努力，忍受了那么多的寂寞和痛苦。可我也没见你有多优秀！',
		'你多努力一点，获得的打击就多一点。',
		'那些年立下的FLAG自己删了吧，反正也没人记得。',
		'没有什么事情能把人一次击倒，只要足够坚强，它会持续的把你击倒！',
		'没有人能让那你放弃减肥，你自己想想就会放弃了。',
		'厉害的不是你有多少后台，而是你能成为多少人的后台！',
		'就算睡得晚，不会找你的人还是不会找你！',
		'今天的事不用放在今天做，万一明天死了呢，就可以不用做了。',
		'很多时候，乐观的态度和好听的话帮不了你。',
		'狗是人类最好的朋友。 然而狗最好的朋友是「屎」。',
		'给你的梦想插上翅膀，虽然不一定飞得很远，但肯定摔的很重！',
		'打趴下就不要爬起来了，反正还是会被打到趴下！',
		'曾经我也是打算靠脸吃饭的，后来差点饿死才放弃的。',
		'不要以为世界抛弃了你，世界根本没空搭理你！',
		'别总骂恨铁不成钢，是你自己忘了，铁本来就不能成钢的啊。',
		'别人问你有谈恋爱吗？就说现在没有。可以机智地掩盖过去也没有的事实。',
		'别看我平时对你漠不关心，其实私下里我每天都盼着你出事！',
		'抱怨不会改变生活，但是钱可以！',
		'白天嘈杂得不愿意醒，夜晚安静得舍不得睡。',
		'做一天的好人并不难，难的是做一辈子有钱人。',
		'做题前，先想想出题者的用意，我觉得他想我死。',
		'做事一定要考虑别人的感受，千万不能让他们太开心了。',
		'做任何事情一定要坚持下去，总会让你看到，失败的那一天。',
		'做人要谦虚，多听听他人的意见，然后认真记下他们的名字。',
		'做人要安安稳稳本本分分，因为，你也根本搞不出什么幺蛾子。',
		'做梦梦到自己在考试，然后被吓醒，发现自己真的在考试。',
		'做了一个风险非常大的投资，要是成功一下就能挣几个亿，要失败我这两块就打水漂了。',
		'做好万全的准备，就是为了当机会来临时，你可以巧妙地避开它。',
		'做好人没希望，做坏人不擅长。',
		'作为失败的典型，你实在是太成功了。',
		'昨天遇见小学同班同学，没想到他混的这么差，只往我碗里放了一块钱。',
		'昨天一个小偷，来我家偷钱，我们一起找了一晚上。',
		'最怕你一生碌碌无为，还安慰自己说平凡可贵。',
		'最近一个月，总有那么三十天很不顺。',
		'总是在凌晨想通很多事情，又在天亮之后，忘得一干二净。',
		'总结一下你的，留下你的不开心，让大家开心开心。',
		'自由从来不是什么理所当然的东西，而是一项需要极高成本的特权。',
		'自古情深留不住，总是套路得人心。',
		'装逼只是瞬间，不要脸那才是永恒。',
		'赚钱就像便秘 — 老难了；花钱就像拉稀 — 憋不住。',
		'转角一般不会遇到爱，只会遇到乞丐。',
		'注重细节，从小事做起，因为你根本做不了大事。',
		'众里寻她千百度，蓦然回首，那人依旧对我不屑一顾。',
		'终于中了万，兑奖的时候，笑醒了。',
		'至少在夏天，富得流油你已经做到了一半。',
		'知识给你力量，无知会给你更强大无畏，且无法预测的力量。',
		'知道为什么天妒英才吗？ 因为没人去管笨蛋活了多久。',
		'知道为何自古红颜多薄命吗？因为没人在意丑的人活多久。',
		'只有在车站大排长龙时，才能真正意识到，自己是龙的传人。',
		'只有在，请假扣工资时，才觉得自己工资高。',
		'只有努力过了才知道，智商上的差距是不可逾越的。',
		'只有努力过了才知道，智商上的差距，是不可逾越的。',
		'只有努力过的人才知道，背景是多么重要！',
		'只有多替领导背锅，领导才会把你，当成傻子啊。',
		'只要有快递还在路上，就感觉这生活，还算有点希望。',
		'只要选对了人生的方向，很容易就成功了，让我们恭喜只要和很容易。',
		'只要我肯努力，没什么事情是我搞不砸的。',
		'只要我吃的夠快，体重绝对追不上我！',
		'只要是石头，到哪里都不会发光。',
		'只要努力的时间足够长，搞不好，你还可以失败的更彻底。',
		'只要你每天坚持学习，最终胜利肯定是属于，在考场上发挥好的人。',
		'只要你肯吃苦，肯努力，肯放下身段，去要饭，总会有人赶的',
		'只要能用钱解决的事情，我一件都解决不了。',
		'只要坚持不懈，嘲笑你的人，迟早会被你笑死。',
		'只要功夫深铁杵磨成针，但真把铁杵磨成针的，绝对是大傻瓜。',
		'只要锄头挥得好，没有墙角挖不倒。',
		'只是因为在人群中，多看了你一眼，你就以为我要坐你的摩的。',
		'挣钱是一种能力，花钱是一种技术，我能力有限技术却很高。',
		'正在输入…，给了多少人希望，又给了多少人失望。',
		'正月初五迎财神，那都是有钱人的事，你就洗洗睡吧。',
		'真正努力过的人才知道，智商上的差距是不可逾越的。',
		'真正努力过的人，就会明白，天赋是有多么重要。',
		'真正的勇士，敢于直面银行卡上的余额，敢于正视磅秤上的数字。',
		'真正的吃货，是可以把月供看成月饼的。',
		'真希望有一天我的钱包，可以和我的脸皮一样厚。',
		'这一秒不放弃，下一秒，就更绝望了。',
		'这世上如果有什么真理，那就是活该！',
		'这世上没谁离不开谁，就算是一条鱼离开水，也能烤着吃。',
		'这年头有些人靠脸吃饭，而有些人，靠不要脸吃饭。',
		'这年头放个假真不容易，连放假都要沾老祖宗的光。',
		'这年头，哪有不分手的恋爱，只有不伤手的立白。遇事得看开一点。',
		'这么多年没掉入桃色陷阱，靠的就是两个字，没钱。',
		'这两天雨水多，下雨记得打伞，否则脑袋容易进水。',
		'这孩子不是笨，就是学习方法不对。学习方法都找不对还不是笨啊？',
		'这个年纪会在你耳边唱歌，喜欢你的肉体还会送你包的，只剩下蚊子了。',
		'这次期末考，我会用实力告诉你，我们年级共有多少人。',
		'这辈子最灿烂的笑容，大概都奉献给，我的手机屏幕了。',
		'这辈子这么苦，别太拼，下辈子还会更苦的。',
		'找对象还是眼光高点好，你总得为，没有人喜欢你找个借口吧。',
		'找对象的时候，不要光看对方外表，得先看看自己外表！',
		'仗义每从屠狗辈，负心多是读书人。',
		'长的美与不美不重要，想的美才是真的美！',
		'长的好看的才能叫吃货，长的不好看的只能叫饭桶。',
		'长的丑不是我的错，只是我在落地时太匆忙了，来不急打扮。',
		'长得帅的踢键子都帅，长得丑的，打高尔夫都像在铲屎。',
		'长得好看的才叫吃货，长得不好看的那叫饭桶！',
		'长得丑怎么了？我自己又看不到，恶心的是你们！',
		'债主，就是那个你破了产，也不会抛弃你的人。',
		'早睡早起身体好，可是晚睡晚起真的心情好。',
		'早上醒来，我以为自己长大了，原来是被子盖横了～',
		'早起的鸟儿有虫吃，可惜你是那条虫。',
		'早点睡吧，因为你喜欢的人，早就跟别人睡着了。',
		'早晨起来照镜子，安慰自己说没事，还有比我更丑的。',
		'糟糕的从来都不只是今天，还有你的以后。',
		'在你最需要帮助的时候，只有鬼才来帮你。',
		'再也沒有任何事情，比晚睡更快樂了，除了晚起。',
		'再努力一点，你就能走向，人生癫疯。',
		'再苦不能苦孩子，再穷也得穷得瑟。',
		'再不疯狂就老了，疯狂过后发现老的更快。',
		'运动一周瘦不下来不要紧，因为运动十周也瘦不下来的。',
		'运动后，你会惊喜地发现，自己只是从肥胖变成壮。',
		'月老麻烦下次为我牵红线，能换成钢丝吗？红线老TM断。',
		'愿你以后，有酒有肉有姑娘，姑娘丑的不像样。',
		'愿你的烦恼，像你的头发一样，越来越少。',
		'愿得一人心，免得老相亲。',
		'远方的路，除了未知，还有绝望。',
		'遇到喜欢的人就勇敢追求，这样你才能知道，拒绝你的人远不止一个。',
		'遇到喜欢的女生要勇敢表白，只有你主动了，才知道她名花有主。',
		'遇到闪电记得要微笑，因为那是天空在给你拍照。',
		'遇到你之前，我的世界是黑白的，遇见你之后 哇靠 全黑了。',
		'遇到困难的时候暂时放一放，第二天的时候，就再也想不起来了。',
		'遇到困难的三个步骤，面对它 处理它，放弃它。',
		'愚人节表白算什么，清明节表白才是王道，失败了还可以说是鬼附身了！',
		'愚人节，只是给说谎的人，一个说真话的机会。',
		'鱼与熊掌不可兼得，但穷和丑可以啊。',
		'鱼和熊掌不可兼得，但单身和穷可以！',
		'余生不想请你指教了，领教够了',
		'又一天过去了，怎么样，是不是梦想更遥远了？',
		'又到了一切矛盾，都能用「大过年的」四个字，解决的时候了。',
		'有缘千里来相会，无缘倒也省话费。',
		'有一天你会遇到一个妹子，她不要你的房也不要你的车，她也不要你。',
		'有一段情，叫自作多情。',
		'有些事情还是要坚持的，比如睡觉，特别是闹钟响起的那一刻。',
		'有些事或人，不是你有钱就可以搞定的，你得有很多钱。',
		'有些事不是我不在意，而是我在意了，又能怎样？',
		'有些事，不说是个结，说了是个疤。',
		'有些人一旦错过了，真特么谢天谢地。',
		'有些人是好看的，有些人是难看的，而你是好难看的。',
		'有些人努力了一辈子，就是从社会的四流，挤入了三流。',
		'有些人就是四，除了二，还是二。',
		'有些人出现在你的生活里，是想告诉你，你真好骗啊！',
		'有些人表面光鲜亮丽，实际上，船袜已经滑到了脚底板。',
		'有时你会觉得自己就是个SB，别灰心，至少感觉是对的。',
		'有时候别人对你很冷淡，可能并不是你的问题。他也许只是不喜欢丑的而已。',
		'有时候，只要你下定决心做某件事，全世界都会拖你后腿。',
		'有什么不开心就睡一觉，没什么是睡一觉不能解决的，如果有那就再睡个回笼觉。',
		'有人一笑就很好看，你是一看就挺好笑。',
		'有人考试靠实力，有人考试靠视力，尼玛我考试靠想象力！',
		'有人存你号码是为了打给你，我不一样，我是为了不接。',
		'有钱人终成眷属，没钱人只能吃土。',
		'有钱人终成眷属，没钱人亲眼目睹。',
		'有钱人离我好近，有钱离我好远！',
		'有钱人可以选择低调，而你，却只能低调。',
		'有钱能买来幸福吗？不能，有钱本身就是幸福！',
		'有钱了不起啊？有钱，真的了不起。',
		'有朋自远方来，虽远必诛。',
		'有困难要帮，没有困难，制造困难也要帮。',
		'有很多时候，面子不是别人给的，是自己凑上来丢的。',
		'有股强烈的学习欲望，幸好我自制力强，压下去了。',
		'有个姑娘问我借钱去整容，整的挺成功，我再没认出是谁问我借的钱。',
		'友谊是什么？你智障多年，我不离不弃。',
		'友情越来越少，礼尚往来越来越多。',
		'由于性格太内向，一直做不出，抢着结账这种事。',
		'用钱当然买不到快乐，只是有钱，别人会想办法让你快乐。',
		'用美颜手机自拍多了，越来越不知道，自己有多丑了。',
		'用扯淡的态度，面对操蛋的人生。',
		'用B形容你，人家铅笔不乐意。',
		'勇敢面对磨难，那些杀不死你的顶多是让你，留下残疾。',
		'永远不要自暴自弃，一旦开始放弃，你就会发现非常开心',
		'英雄一怒为红颜，红颜一怒，得花钱。',
		'因为穷我连关心你都不敢，就怕你说嘘寒问暖，不如打笔巨款。',
		'以我的资历和文凭，将来这个城市的大街，都归我扫。',
		'以前我每天都会买彩票，终于有一天，我连彩票都买不起了。',
		'以前虽然穷但是很开心。现在不同往日了，不止穷还不开心。',
		'以前上学是拿钱混日子，现在工作了，是在拿日子混钱。',
		'以前觉得靠关系的人，一定很无能，接触后发现人家样样比我强。',
		'以前过年就图个热闹，现在就想图个清静。',
		'以前除了读书什么都不懂，现在除了读书什么都懂。',
		'以后要对女朋友好一点，毕竟她已经瞎了，不能再受伤害了。',
		'以后没钱了先找我借，我不想做最后一个，让你失望的人。',
		'研究证明常年抽烟喝酒的人，患老年痴呆的概率较低，因为早死的概率较高。',
		'学校教学楼放镜子，是为了让你知道，人丑就要多读书。',
		'学习使人快乐，不学习使人，更快乐。',
		'学海无涯，回头是岸。',
		'学过很多技能，到头来才发现，最有用的技能是——想开点！',
		'学而不思则罔，思而不学则殆。不思不学成网贷。',
		'选择比努力更重要，所以我选择不努力',
		'秀恩爱的最好在中午秀，因为，早晚都会有报应。',
		'胸怀鸿鹄之志，手无缚鸡之力。',
		'兄弟听我一句劝，游戏没了还能重玩，媳妇没了游戏就能一直玩了。',
		'幸亏你去年没洗头，要不然你今年，炒菜连油都没有。',
		'醒醒，你这不是丧而是，没有钱和性生活的正常表现。',
		'信就信，不信就不信，还TM整个微信。',
		'心是伟大的诗人，而嘴是蹩脚的编辑。',
		'心软不是病，回头才致命。',
		'心灵鸡汤是给吃惯了鲍参翅肚的人做的换口味小菜，屌丝以为喝一碗鸡汤就营养全面提升了？',
		'心比天高，命比纸薄。',
		'小时候做过的最蠢的事，可能是盼着长大吧。',
		'小时候最讨厌吃饭和睡觉，现在想想真贱。',
		'小时候我们都很快乐，因为那个时候我们，丑和穷都还不是那么明显。',
		'想做你的太阳，高兴的时候温暖你，不高兴的时候晒死你。',
		'想要打起精神，却一不小心把它打死了。',
		'乡愁是一张小小的车票，我在这头，黄牛在那头。',
		'现在流的泪，都是当初脑子进的水。',
		'现在苦点没关系，人只要活着就一定会有好事，发生在别人身上。',
		'咸鱼翻了身，也还是咸鱼。',
		'喜欢一个人是藏不住的，就算躲在衣柜里，还是会被她老公发现。',
		'喜欢一个人就去表白，万一，成备胎了呢？',
		'喜欢就要表白，这样才能知道你是几号备胎。',
		'希望有些事情可以自己解决，不是我自己，是事情自己。',
		'希望无时无刻不在，而你，每时每刻都错过。',
		'希望是火，失望是烟，人生就是一边生火一边冒烟。',
		'西游记告诉我们，有个猪一样的队友，能让团队上西天。',
		'物以类聚人以穷分，有钱人终成眷属。',
		'武则天证明了，成功和性别没关系，你证明了成功和你没关系。',
		'吾日三省吾身，吾没钱 吾没车 吾没房。',
		'无论最后我们疏远成什么样，一个红包，就能回到当初。',
		'无论遇到任何事情，在哪里跌倒，就在那多躺一会吧。',
		'无论你二或不二，二就在那里，不三不四。',
		'无毒的身躯扛下有毒的疫苗，你是教育我从小就要坚强！',
		'我最大的缺点，就是缺点钱。',
		'我知道虚度年华不对，但是这样，真的好过瘾啊。',
		'我知道岁月会磨平我的棱角，但没想到，是把我按在地上摩擦。',
		'我只想和你叙叙旧，你却问我要不要代购。',
		'我真的挺羡慕你的皮肤，你说你是怎么能，把它保养的那么厚呢？',
		'我这人从来不记仇，一般有仇当场就报了。',
		'我这人不太懂音乐，所以时而不靠谱，时而不着调。',
		'我这人吧，永远不要挑战我的底线，否则我又得修改底线。',
		'我这辈子没求过谁，只求过阴影部分面积。',
		'我有一颗早起的心，可我的被子和床不同意。',
		'我有一个梦想，只是有一个梦想。',
		'我有个朋友停止了抱怨，开始努力奋斗，几年过去了还是这个鸟样。',
		'我因为穷，所以国庆在家，躲过了一节。',
		'我以为我们能一起走到最后，谁知道，你走了两步就要打车。',
		'我以为明天会更好，后来我天天盼着明天。',
		'我已经不是那个花五十块钱，也要考虑很久的小孩了，现在五块钱都要深思熟虑。',
		'我上班就是为了赚钱，别和我谈理想，我的理想是不上班。',
		'我擅长做空A股，只要我一买，立刻跌。',
		'我亲眼看着你走上台，不知道你是将要献丑，还是出丑。',
		'我能想到最浪漫的事，就是看你一人慢慢变老。',
		'我能想到最浪漫的事，就是和你一起吃吃吃，然后你付钱。',
		'我能想到，对自己最准确的形容词只有：肥美。',
		'我们是好朋友，你摔倒了我会把你扶起来，不过要等我笑完。',
		'我们非常努力，才能活得像个普通人',
		'我们都史无前例的有默契，突然你不理我我也不理你。',
		'我每天拼了命努力就是为了，向那些看不起我的人证明，他们是对的。',
		'我没有去过你的城市，但我刷过你那的题。',
		'我连穷和丑都不怕，还怕单身？',
		'我连名牌都不认识几个，有时候，别人在炫富我都不知道。',
		'我可以划船没有桨，我可以扬帆没有方向，因为我这一生全靠浪。',
		'我觉得一定有很多人暗恋我，因为这么多年了，也没有人跟我表白！',
		'我觉得失恋不可怕，眼瞎才可怕。',
		'我交朋友，从不在乎他有没有钱，反正都没有我穷。',
		'我捡了个神灯，许愿我死前能找到女朋友，结果我获得了永生！',
		'我好想你，第一句是假的，第二句也是假的。',
		'我鼓足勇气去面对现实，却发现勇气，真的只是气而已。',
		'我发现我挺能哄女孩睡觉的，只要我一发信息，女孩就说我要睡觉了。',
		'我对生活充满向往，生活对我虽远必诛。',
		'我的原则，只有三个字，看心情。',
		'我的意中人是个盖世英雄，总有一天他会，踩着七色彩云去娶别人。',
		'我的眼里只有你，因为你的大脸，让我看不到别人。',
		'我的兴趣爱好分动态和静态，动态就是翻身，静态就是睡觉。',
		'我的未来就是个梦，更遗憾的是，这会儿还失眠。',
		'我的社交恐惧症，主要来自于，收入低。???',
		'我的钱虽然不是大风刮来的，但像被大风刮走的。',
		'我的脑袋不是空的。我是要大作为的人，只是混沌初开。',
		'我的目标是三十岁有套房子，现在实现一半，已经三十岁了。',
		'我到底是活了年，还是活了天，重复了年？',
		'我从你眼里看到了两样东西，一样是真诚，而另一样是眼屎。',
		'我从来不会脑残地，在网上晒自己买的名牌，因为我买不起。',
		'我从曾经的一无所有，到现在的身无分文。',
		'我从不以强凌弱，我欺负他之前，真不晓得他比我弱。',
		'我从不去想何时能成功，既然选择了远方，那就还远着呢。',
		'我丑，是为了降低画质提高性能，为什么我的人生还那么卡呢？',
		'我超级超级喜欢小动物，怎么说呢，就是顿顿都有吧。',
		'我尝试着做一个有趣的人，后来却跑偏了，成了一个逗逼。',
		'我曾经得过精神分裂症，但现在我们已经康复了。',
		'我不想读书，主要是因为家里牛啊，猪啊羊啊都没人喂。',
		'我不是诸葛亮，也没有草船，但为何你的贱一直往我这放？',
		'我不是那种，落井下石的人，我是直接把井封了。',
		'我不是矮，我只是离天空比较远。',
		'我不怕变成自己厌恶的人，我怕过得还不如他们。',
		'我不骂人，那是因为我，动手能力比较强。',
		'我不会两面三刀，可我经常被两面插三刀。',
		'我本想享受生活，结果发现活下来都很困难。',
		'我把她从女孩变成了女人，她把我从男孩变成了，穷人。',
		'问世间钱为何物，只叫人生死相许。',
		'问渠那得清如许，唯有毒汤活水来！',
		'问君能有几多愁，恰似一群太监上青楼。',
		'唯一比孤独更可怕的，是被人知道你孤独。',
		'为什么总是天妒英才呢？因为没人管笨蛋活多久。',
		'为什么中国人结婚，都非要选个好日子呢？因为结完婚就没好日子过了！',
		'为什么在学校，一上课就想睡觉？因为学校是梦开始的地方。',
		'为什么要吵架呢？就不能心平气和的坐下来，打对方几巴掌吗？',
		'为什么你能像智障一样活着，而我却不可以。',
		'为什么家长只看分数？废话！难道他们看得懂题目？',
		'为了防止我这个月又乱花钱，我提前把钱，都花完了。',
		'为了变漂亮，你坚持了哪些好习惯？坚持开美颜。',
		'望穿秋水之寒，无论如何也比不了，忘穿秋裤之冷。',
		'忘记以前的不开心，因为以后会更不开心。',
		'往往那些不起眼的小餐馆，才能吃到真正的美味，而那些大酒店的我吃不起。',
		'往事不堪回首，是因为，你根本没有可以回首的往事。',
		'王子拿着留下的码水晶鞋陷入沉思',
		'玩手机时间长要让眼睛休息，把视线投向窗外，想一想为什么自己这么穷。',
		'外貌不重要，爱情看的是感觉，可是人家对丑的没感觉。',
		'脱了衣服我是禽兽，穿上衣服，我是衣冠禽兽。',
		'脱发怎么办？要健康饮食保持良好心态，这样就能接受这个事实了。',
		'突然发现，起床第一件事是摸手机，睡前最后一件事是放下手机。',
		'突破瓶颈之后，发现还有瓶盖。',
		'投对了简历找到一份好工作，投对了胎，可以不用找工作。',
		'偷一个人的主意是剽窃，偷很多人的主意是研究。',
		'同样是出卖自己，有的人成了大姐，有的人成了小姐。',
		'同样都是咸鱼，为什么别人可以翻身，而你却粘锅了？',
		'同甘共苦你不陪，荣华富贵你是谁？',
		'聽說七月鬼門快開了，你總算不是孤家寡人了。',
		'听说自从你得了神经病，整个人都精神多了。',
		'听说你过的没我好，那我就放心了。',
		'听说你过的不好，我蹲在门口，笑了一整天。',
		'听说你的城市下雨了，不知道你带伞没有，如果带了这雨就白下了。',
		'听君一席话，浪费十分钟。',
		'听成绩的时候要用右耳听，因为左耳靠近心脏，可能会猝死。',
		'铁打的身子，磁铁打的床。',
		'铁杵能磨成针，但木杵只能磨成牙签。材料不对再努力也没用。',
		'条条大路通罗马，每条都有收费站。',
		'条条大路通罗马，可是有人就出生在罗马',
		'条条大路通罗马，而有些人，就生在罗马。',
		'天涯何處無芳草，全都長在別人家。',
		'天生我才必有用，前提是，你得是天生的。',
		'天没降什么大任于我，照样苦我心智，劳我筋骨。',
		'天空没有翅膀的痕迹，除非你飞的时候会掉毛',
		'天将降大任于斯人也，必先苦其心志劳其筋骨，后来天改主意了。',
		'特别能吃苦这五个字，我想了想，我只能做到前四个。',
		'逃避是解决不了问题的，不逃你也解决不了啊。',
		'倘若互不相欠，怎会再次相见。',
		'谈钱伤感情，谈感情伤钱。',
		'摊煎饼的大妈说，她月入三万，不差你一个鸡蛋。',
		'贪图小利，难成大事，要贪就贪大的。',
		'他喜欢你素颜，必须是素颜好看。',
		'他们笑我长的丑，我笑他们讲的对。',
		'他们说网络很假，我笑了，好像现实很真一样。',
		'所有的故事都会有结局，只有生活跟你没完。',
		'所谓婚姻，就是两个家庭的，资产重组。',
		'所谓复习就是，把不会的东西再确认一遍，你确实不会。',
		'岁月是把杀猪刀可他拿丑的人一点办法都没有',
		'岁月是把杀猪刀，可是他拿丑的人，一点办法都没有。',
		'岁月让我知道，除了快递，我谁都不必等。',
		'随风奔跑自由是方向，无奈忘了腿短没力量。',
		'虽然我长得丑，但是买了漂亮衣服，我就可以丑的漂亮。',
		'虽然你长的丑，但是你想得美啊。',
		'虽然你长得矮，但你发际线高啊。',
		'虽然你已无法再长高了，但是你可以继续长胖啊。',
		'虽然你学的慢，但是你，放弃的快呀。',
		'虽然你单身，但是你胖若两人。',
		'虽然你搬砖的样子很累，但是，你充钱的样子真的很帅。',
		'虽然脑子和肠子长得很像，但你也不能老是用来装屎啊！',
		'俗话说人无远虑，必定很有钱。',
		'俗话说祸不单行，可见连祸都是有伴儿的，你再看看你。',
		'送你喜欢的女生一支口红吧，至少她亲别人的时候，有你的参与感。',
		'思想给了我们太多的自由，而我们拖累了思想！',
		'说好我们一起到白头，你却偷偷焗了油。',
		'说错话不要紧，你还会继续说错的。',
		'顺其自然只是无能为力的另一种说法',
		'睡觉睡到手抽筋，数钱数到自然醒。',
		'谁说我不会乐器？我退堂鼓打的可好了。',
		'谁说我不会乐器，我打退堂鼓可好了！',
		'谁说你没有真爱，烦恼与你同在。',
		'谁说你没有毅力的，单身这件事，你不就坚持了好几十年吗？',
		'谁说你不爱运动？你不仅会踢皮球，而且踢的可好了。',
		'谁说金钱买不到时间，网管再续两个小时。',
		'双十一过后，我从一个光棍，变成了一个负债累累的光棍。',
		'熟练地运用，关我屁事和关你屁事，可以节省人生%的时间。',
		'书山有路勤为径，怪你没有富贵命。',
		'瘦的人能把衣服穿出故事，胖的人只能穿成事故。',
		'手机摔了这么多次都没事，想想还是我的身高救了它。',
		'手机的寿命是人类的/，请放下身边的杂事，好好陪陪它！',
		'是金子总会发光，但你只是块肥肉。',
		'是好久不见，还是，视而不见。',
		'试着去了解那些你讨厌的人，你会发现，真是越看越讨厌。',
		'事情多不可怕，可怕的是你没能力解决。',
		'世上只有骗子是真心的，因为他是真心地在骗你。',
		'世上无难事只怕有钱人，物以类聚人以穷分。',
		'世上无难事，只要肯放弃！',
		'时间就像胸，挤挤就有了，躺下就没了。',
		'时间就是金钱，我在浪费时间？不～我只是在炫富！',
		'时间会帮你攒够失望，并告诉你不用谢。',
		'失眠睡不着，可能是因为，你手机还有电。',
		'失败是成功之母，可惜成功六亲不认。',
		'失败乃成功之母，可是我TM失败的次数太多，都不知道谁是亲妈。',
		'失败乃成功之母，可失败连男朋友都没有。',
		'失败乃成功之母，但往往失败都是，不孕不育。',
		'失败的尽头是绝望，努力的终点是过劳。',
		'失败不可怕，可怕的是，你还相信这句话。',
		'生平最讨厌溜须拍马的人，和他们在一起，显得老子很不会做人。',
		'生命中必然要放弃某些人，不是你不在乎，是他们不在乎。',
		'生活中很多人喜欢小题大作，其实真的没有必要，要想想大题怎么办。',
		'生活磨光你的棱角，是为了让你，滚的更远。',
		'生活没有翻不过去的坎，只有翻不完的坎。',
		'生活就像海绵里的水，只要你不愿意挤，总有一天会蒸发完的。',
		'生活会让你苦上一阵子，等你适应以后，再让你苦上一辈子。',
		'生活还是有意思的，毕竟每天都因为不同的原因想死。',
		'生活费就像大姨妈，一个月来一次，几天就没了。',
		'生活不止眼前的压力，还有背后的灾难。',
		'生活不止眼前的苟且，还有一辈子的苟且。',
		'生活不止眼前的苟且，还有前任的喜帖，所以拉黑很重要。',
		'生活不是这样就是那样，总之，不会是你想的那样。',
		'生活不仅有眼前的苟且，还有远方的枸杞。',
		'生活不会放弃你，但也不会放过你。',
		'生活，开始对我这种小鸡爪子，放泡椒了！',
		'什么事情可以让你，放下尊严低声下气？抄作业。',
		'什么时候，能把我脑子里的钱，提现就好了。',
		'什么都在涨价，就是人越来越贱。',
		'身在福中不知福是什么？就是发福快发成猪了，还觉得自己身材蛮OK。',
		'少小离家老大回，骚话学了一大堆。',
		'少年加油吧！只要你努力工作，你的老板一定会成功的。',
		'上帝向人间洒满智慧，唯独你打了把伞。',
		'上帝为什么给你关上一扇门，还不是因为你见不得人。',
		'上帝为你关上一扇门的时候还会顺手帮你把窗户也关上。',
		'上帝为你关上一道门的同时，还会顺带夹你的脑子。',
		'上帝为你关上了一扇门，然后就去洗洗睡了。',
		'上帝为你关上了一扇门，还会给它加上防盗锁，大插销。',
		'上帝不会亏待痴情的人，他都是往死里整。',
		'傻人有傻福，傻B没有。',
		'三观没用，你得靠五官！',
		'三分天注定，七分靠打拼，还有分看脸。',
		'三百六十行，行行出BUG。',
		'若你的朋友每天生活都这么幸福，也就不会拍成照片发到朋友圈了。',
		'如果再见不用红着脸，是否还能借点钱。',
		'如果有一天我消失了，即使我的朋友恋人不会找我，银行也会疯狂找我。',
		'如果有天发现你一夜暴富了，给自己一巴掌，快醒来别上班迟到了。',
		'如果有钱也是一种错，那我情愿，一错再错。',
		'如果一个人秒回了你，那只能说明，他刚好在玩手机。',
		'如果我有什么，让你不喜欢的地方，麻烦你自己克服一下。',
		'如果我的人生是一部电影，那你就是一个弹出来的广告。',
		'如果时间可以倒流，那一定是，你在做梦。',
		'如果生活欺骗了你，不要着急 — 拿出美颜相机，去欺骗生活。',
		'如果人生是一部电影，那你就是，中间弹出来的广告。',
		'如果全世界都不要你了，你要记得还有我，我也不要你。',
		'如果全世界都不要你了，记得要来找我，我认识好几个人贩子。',
		'如果你真的想要做好一件事，全世界都会为你挡路。',
		'如果你愿意，一层一层一层地剥开我的心，你会发现我缺心眼。',
		'如果你有什么事，一定要告诉我，反正我也解决不了。',
		'如果你喜欢一个女孩，就好好努力多挣钱，到时候多随点份子钱。',
		'如果你特别迷恋一个人，那么你一定配不上他！',
		'如果你容不下我，说明不是你的心胸太狭窄，就是我的人格太伟大。',
		'如果你去抢银行，不论成功还是失败，未来十年内你都不用再上班。',
		'如果你面前有一大笔钱，和一个万人迷，那么这和你有什么关系呢？',
		'如果你觉得每天都忙成狗，那一定是你的错觉。狗一定没你忙。',
		'如果你觉得，围着你的都是苍蝇，那可能你自己是坨屎。',
		'如果你花钱都不开心，那么是你花钱方式不对。',
		'如果你还在坚持，说明你还不够绝望。',
		'如果你放弃了今天的自己，你就战胜了明天的你。',
		'如果你跌倒了，那就，找个舒服的姿势趴着吧。',
		'如果你的前半生过得很坎坷，也不必太担心，下半生你就会适应的。',
		'如果你的男朋友对你百依百顺，从不拈花惹草。可能是因为他钱不够。',
		'如果你吃了亏，千万不要喝水，不然你会变污的。',
		'如果你不珍惜我，那么过了这个村，我在下一个村等你。',
		'如果你变成了备胎，请忘记你也是千斤顶。',
		'如果婚姻是爱情的坟墓，一年一次的结婚周年庆祝，便是在扫墓 了。',
		'如果过年你看到我脸色不好，别想太多，就是你忘给红包了。',
		'如果多年以后你未嫁我未娶，那么咱俩，也真够完犊子的了。',
		'如果吃鱼可以补脑，你这智商，至少要吃一条鲸鱼。',
		'如果吃亏是福的话，那我可能早就福如东海了。',
		'如果不能一夜暴富，两夜也可以，三晚我也不嫌多。',
		'如果不能美得惊人，那就丑得销魂吧！',
		'任何时候都要记得微笑，这会让你看起来，像个不能随便惹的神经病。',
		'认识陌生人其实很麻烦，许多谎话又得重新说起。',
		'忍无可忍，就重新再忍。',
		'人总有一死，不是穷死就是心死。',
		'人终有一死，或轻于鸿毛，或重于鸿毛。',
		'人一辈子都在寻找成功，但更多时候，找到的都是成功他妈！',
		'人要是决定自暴自弃了，就会活得特别开心。',
		'人要是行，干一行行一行一行行行行行，行行行干哪行都行。',
		'人心不足蛇吞象，没有实力别硬上！',
		'人为什么叫人类，因为人活着就是累。',
		'人生最大的耻辱是什么，考试作弊了还不及格。',
		'人生有两大悲剧，一个是得不到想要的东西，另一个是得到不想要的东西。',
		'人生如梦我失眠，人生如戏我穿帮，人生如歌我跑调。',
		'人生没有过不去的坎，只有一坎接一坎。',
		'人生没有过不去的坎，过不去，只是因为你腿短。',
		'人生嘛，就是起起落落落落落落。到底了自然就会蹦跶两下。',
		'人生苦短，我又他妈懒',
		'人生就像一个茶几，上面摆满了杯具。',
		'人生就像打电话，不是你先挂就是我先挂。',
		'人生就是六个大字，怎么着都不行。',
		'人生和骑自行车不同，就算走下坡路，也不会轻松。',
		'人生第一次说谎，大多数都是，从写作文开始。',
		'人生的痛苦，不是因为没钱而痛苦，而是因为别人有钱你痛苦。',
		'人生不如意之事十有八九，剩下的十之一二，超级不如意',
		'人生不如意十有八九，从来没碰见过一二。',
		'人生不如意何止八九，可与人言者何至二三。',
		'人生不如意的事十有八九，剩下的一二更加不如意！',
		'人如果没有梦想，那跟无忧无虑有什么分别？',
		'人人都想上天堂，却没有人想死。',
		'人们常说，不要让青春留白，所以我把它抹黑了！',
		'人家谈恋爱，靠长相靠浪漫靠烧钱，而你靠对方眼瞎。',
		'人家呢只是胖着玩玩，而你是丑的认真。',
		'人家不是无趣，而是，懒得对你有趣。',
		'人和猪的区别就是，猪一直是猪，而人有时却不是人。',
		'人还是要有梦想的，即使是咸鱼，也要做最咸的那一条。',
		'人还是要有梦想的，即使是咸鱼， 也要做最咸的那一条。',
		'人都需要努力的，努力过后你就会发现，你还真的是很普通。',
		'人的一生，三分天注定七分靠打拼，剩下的九十分靠父母。',
		'人丑就要多健身，这样就能在别人说你丑时，你可以揍他。',
		'人丑就要多读书，这样以后，才能有钱整容。',
		'人丑就要多读书，书并不能使你变得好看，却能让你更容易接受现实。',
		'人丑就要多读书，反正，其他什么事也与你无关。',
		'人不能低下高贵的头，但捡钱时例外。',
		'让刻苦成为习惯，用汗水浇灌未来，然后脱水而死。',
		'群发的祝福和个位数的红包，都是没有灵魂的。',
		'去年定了一个目标存款三万，今年掐指一算，还差五万。',
		'去看精神科时医生说，你没啥抑郁症，你是真的惨。',
		'秋天是收获的季节。别人的收获是成功与快乐，你的收获是认识到并不是每个人都会成功与快乐。',
		'窮一點不要緊，要緊的是不只一點。',
		'穷只是暂时的，只要你努力，你会发现你慢慢就习惯了。',
		'穷你就努力啊！不努力折腾，你怎么负债百万。',
		'穷不要紧，抬头挺胸让大家看看，你不仅穷还丑还矮。',
		'穷不可怕，可怕的是，最穷的人是我。',
		'穷，不是一种状态，而是一种常态。',
		'请珍惜那些伤害过你的人，毕竟其他人都懒得害你。',
		'请珍惜对你好的人，否则错过了就不知道何时，才能再遇到另一个瞎了眼的。',
		'请相信我，我所说的每句话，都是废话！',
		'请问在三伏天，有什么消暑良方吗？薪尽自然凉。',
		'请不要叫我宅女，请叫我居里夫人。',
		'情商最低的一句话，你踢我干啥？',
		'情人节不出意外的话，一个人过，出意外的话在医院过。',
		'清明节，应该回你的学校扫扫墓，因为那里埋葬了你的青春。',
		'悄悄地我吃了，正如我悄悄地胖。',
		'强扭的瓜甜不甜不重要，只要能解渴就行了。',
		'强扭的瓜不甜，但是解渴啊！',
		'钱虽然难赚，但是容易花啊。',
		'钱买不来快乐，那一定是，你的钱太少了！',
		'钱买不来爱情，但是可以买走爱情。',
		'钱对你真的就那么重要吗？讲了个多小时了，一分钱都不降。',
		'钱不是万能的，但有钱真的可以为所欲为。',
		'钱包里放老婆的照片，是为了提醒自己记住，钱包里的钱是怎么没的。',
		'前世五百次的回眸，却换来今世的一句，流氓。',
		'千万别把事情拖到明天，后天大后天都是好日子啊。',
		'掐指一算，你俩要散。',
		'骑电动车请戴好头盔，否则，开奔驰的同学会认出你。',
		'骑白马的不一定是王子，也可能会是是唐僧！',
		'其实人生，在某个节点后就结束了，大家只是在等彩蛋。',
		'其实你也有超能力，怎么减都不瘦的能力。',
		'其实你也不是一无是处，至少在夏天，你还能喂蚊子。',
		'其实你讨厌的并不是广场舞，而是广场舞大妈。',
		'其实你不丑，只是，你美得不明显。',
		'其实命运，真不是喜欢和你开玩笑，它是很认真的想弄死你。',
		'其实表白未必是件好事，因为那样显得手黑。',
		'其实，电脑游戏从小就训练你，把Boss当作自己最大的敌人。',
		'破罐子不能破摔，得使劲摔！',
		'平时骂你就算了，非要等我打你，才知道我文武双全。',
		'贫穷限制了我那么多，为什么没有限制我的体重？',
		'贫贱不能移的意思就是，穷就好好在家呆着，哪儿也别去。',
		'朋友说借二十块钱回头给你，借完钱之后我才知道，有些人一转身就是一辈子。',
		'胖子是不会饿死的，饿死了也是死胖子 。',
		'怕鬼真的太幼稚了，我带你看看人心。',
		'偶尔还是要出去走一走，才知道躺床上多么舒服。',
		'女为悦己者容，男为悦己者穷!',
		'女生之间的友谊啊，就像塑料花，虽然假但永不凋零。',
		'女生何必勾心斗角互相攀比，反正几十年后，都要一起跳广场舞的。',
		'女人用丝袜征服了男人，男人用丝袜征服了银行。',
		'女票突然变瘦了，多半是漏气了。',
		'努力了这么久，但凡有点儿天赋，也该有些成功的迹象了。',
		'努力加油，每一个困难，都会克服我。',
		'努力过失败过，没关系，重新努力会失败得更好。',
		'宁愿不说话看起来像个傻子，也不要，开口证明自己的确如此。',
		'宁可美的千篇一律 ，也不要丑的各有千秋。',
		'念念不忘，可有回响？',
		'年轻时我以为钱就是一切，现在老了才知道，确实如此。',
		'年轻人嘛，现在没钱算什么，以后没钱的日子还多着呢。',
		'年轻人不要老想着走捷径，父母强才是硬道理。',
		'年龄不是问题，身高不是距离，没钱谁喜欢你？',
		'你坐过最挤的公交车是什么？只是路过，却被挤上了车。',
		'你最想从母校带走的是什么？最想从母校带走的，是我的学费。',
		'你走了真好。不然总担心你要留下来吃饭',
		'你走了真好，不然我总当心，你会留下来吃饭。\\n\\n',
		'你知道投资和投机的区别吗？一个是普通话，一个是广东话。',
		'你只要不抬杠，钱真的是万能的。',
		'你只需看着别人精彩，老天对你另有安排。',
		'你这么擅长安慰他人，一定度过了许多，自己安慰自己的日子吧。',
		'你这两天早点回家，最近偷猪的多，我怕你出事。',
		'你长得很有创意，活得很有勇气。',
		'你怎么长得跟个二维码似的，不扫一下，都不知道你是什么东西！',
		'你在我心里，就像天上的星星，多一颗少一颗都无所谓。',
		'你愿意做我的太阳吗？那么请与我，保持公里。',
		'你有什么擅长的运动吗？「逃避现实」。',
		'你永远不会知道，你的哪个好友，会成为下一个微商。',
		'你以为自己什么也做不好？你错了，你还可以做好一个废物。',
		'你以为有钱人很快乐吗？他们的快乐，你根本想象不到。',
		'你以为向生活低头就好了？生活是想让你跪下。',
		'你以为他给你点赞，是喜欢你？只是手滑罢了。',
		'你以为你是一只虫子，能化茧成蝶，其实你只是一只蛆。',
		'你以为你是灰姑娘吗？拜托别做梦了，她可是伯爵的女儿。',
		'你以为男朋友是取款机，结果是十台机器，有九台半是存款机。',
		'你以为浪子回头金不换，其实浪子可能只是，上岸缓一缓。',
		'你以为今天是最糟的一天么，明天会让你改变这个看法的。',
		'你一无是处，但有件事做得特别好，就是做白日梦。',
		'你一定要笑，不然不会知道，自己有多少鱼尾纹。',
		'你要站在别人角度上去思考，总有一天你会发现，你丢失了自己。',
		'你要相信明天，一定会更好的，更好的把你虐成狗。',
		'你要是喜欢一个女生，就好好学习找个好工作努力挣好多好多钱，等她结婚的时候你多出点份子钱',
		'你要是和自拍长得一样，怎么会没有男朋友。',
		'你要是过得好，我怎么能睡得着。',
		'你要努力的去生活，因为你只有努力了，才知道自己真的不行。',
		'你要么非常努力，要么非常聪明，才能勉强过上平庸的生活。',
		'你想有钱？想想就可以了。',
		'你想瘦成一道闪电么，闪电平均宽度是五米。',
		'你现在所拥有的，都不曾是你的，因为未来你都会失去。',
		'你现在的生活，也许不是你想要的，但绝对是你自找的。',
		'你喜欢我哪一点啊？我喜欢你离我远一点。',
		'你无法用钱买来幸福，因为你根本没钱。',
		'你无法叫醒一个，不回你消息的人，但是红包能。',
		'你踢球受过最重的伤，是女友到球场给对手喂水！',
		'你所有的忧伤，都来自于你的余额。',
		'你虽然没有出过国，但是你每天都在倒时差。',
		'你说自己很丑，我觉得你不仅丑，还净说实话。',
		'你说冰是睡着的水，我只记得屁是屎的叹息。',
		'你是最棒的！不，是最胖的！',
		'你是转角遇到爱，可你想过对方吗？他是转角遇到鬼呀。',
		'你是我的小苹果，哎呀讨厌！我是说我TM真想削你。',
		'你是谁不重要，重要的是，你闯进我生活想干啥？',
		'你是个做事认真的人，认认真真地帮别人，试了所有的错。',
		'你若不离不弃，我特么必死无疑。',
		'你若帮了一急需用钱的朋友，他一定会记得你，在他下次急需用钱的时候。',
		'你若安好，那还得了~ ',
		'你认真的样子，就像天桥上贴膜的。',
		'你人人称道的美丽，里面都有PS的痕迹。',
		'你全力做到的最好，还不如别人随便搞搞。',
		'你前世一定是塑料袋，除了会装还是会装。',
		'你努力找他说话的样子，像极了商场里的导购。',
		'你能接受恋爱年龄差多大？只要长得好看，上下五千年都行。',
		'你们之所以喝鸡汤，是因为肉呢被别人吃光了。',
		'你们的对象叫你们什么？我的对象叫我滚.',
		'你妹是个好姑娘，替你妈分担了很多。',
		'你每天都很困，因为你被生活所困。',
		'你俩看起来真般配，月老的垃圾分类，做的还挺到位。',
		'你连自己都睡不好，还想去睡别人？',
		'你连世界都没观过，哪来的世界观？',
		'你老是这么抠门，门都被你，抠坏了好几扇。',
		'你可以像只猪一样懒，却无法像只猪一样，懒得心安理得。',
		'你就一甘蔗男，刚开始可甜了，到后面全成渣。',
		'你就像我的阳光，看着就刺眼。',
		'你就像是蓝天上的太阳，让人无法直视。',
		'你就算失败了次，也要再努力一次，凑个整数。',
		'你就是个土豆丝，又土又逗，又屌丝。',
		'你就是个黄焖鸡，又黄又闷又垃圾。',
		'你就两点不行，这也不行，那也不行。',
		'你敬人一寸，他将得寸进尺。',
		'你觉得很孤独，没关系，你还有手机。',
		'你家住海边吗？这么浪。',
		'你获得了很多金钱，但同时也失去了很多东西，比如烦恼。',
		'你和学霸的区别就是，你所有的灵光一闪，都是他的基本题型。',
		'你害怕穿的不好看被嘲笑？别担心，穿的好看也一样。',
		'你还是别把我放在心里了，我不喜欢人多的地方。',
		'你还不算惨，惨的人，都没手机用。',
		'你过的好不好别人不知道，别人只能看到矮胖穷。',
		'你过得好我替你高兴，你过得不好，我替全世界高兴。',
		'你给小草一点爱，小草还你一片绿！',
		'你复杂的五官，掩饰不了，你朴素的智商。',
		'你多努力一点，获得的打击就多一点。',
		'你的意中人是个盖世英雄，他每天会骑着七彩祥云，去网吧吃鸡。',
		'你的眼界，不止局限于你的生活环境，还局限于你的视力范围。',
		'你的戏，可以像你的钱一样，少一点吗？',
		'你的晚安，只是想让我闭嘴。',
		'你的人生跟你的发际线一样，后退的特别快。',
		'你的美别人看不到，你的丑一目了然。',
		'你的脸，犹如你的人生，一样坎坷。',
		'你的脸，一分天注定，九分看滤镜。',
		'你的计划，就像零食，吃到肚子里之后就是个屁。',
		'你的臭脚被毒蛇咬了，抢救了个小时，毒蛇终于救了过来。',
		'你的爸爸必须十分努力，才能让你看起来毫不费力。',
		'你得好好努力，才能配得上，被人利用。',
		'你倒下了，能顶替你的人千千万',
		'你打起精神，分钟就能做完的事情，打起精神就要花上小时。',
		'你从来就没成功过，还怕什么失败？',
		'你从来不孤独，因为，孤独都不想跟你交朋友。',
		'你曾是我的太阳，是我的整个世界，现在想想也就是个球。',
		'你不是走在牛B的道路上，而是仍在，装逼的道路上溜达。',
		'你不是一无所有，你还有病！',
		'你不是选择困难症，你只是穷。',
		'你不能总看那些你没有的，多看看你拥有的。算了你把眼睛闭上吧。',
		'你不能因为你胖，就忽略了你的丑。',
		'你不奋斗一下？怎么知道自己有多无能。',
		'你不懂得安排自己的人生，会有很多人帮你安排，他们需要你做的事。',
		'你并没那么缺少安全感，因为没钱是最安全的。',
		'你并非什么事情都不做准备，起码你已经，准备好了要失败的嘛。',
		'你并不是一无所有，你还有病。',
		'你并不是无能，你只是没有选择的权力。',
		'你别看我平时对你，一副漠不关心的样子，其实背地里说了你很多坏话。',
		'你必须敢爱敢恨，才会发现你的爱恨，别人真的不在乎。',
		'你抱什么不好，非要抱病在床！',
		'你把所有不一定，都变成了一定不。',
		'你把钱借给了你的朋友，那么他一定会记得你，在他下一次缺钱时。',
		'你爱不爱你的工作，工作都会在那等你，不离不弃。',
		'能用钱解决的都不是问题，但如何有钱，才是你最大的问题。',
		'能从上到下摸遍你全身的，也就只有，车站安检员了。',
		'能不生气就不要生气，能不骂人就不要骂人，能动手就直接动手。',
		'能不能对我真心一点？当然可以！我是真心不喜欢你。',
		'闹钟的作用对我来说，就是让我，换个姿势睡觉。',
		'腦子有病得治，像你多好，沒有腦子。',
		'脑子是个很棒的东西，希望你有。',
		'难受的时候摸摸自己的胸，告诉自己是汉子，要坚强。',
		'男人单身叫单身狗，女的单身叫狗不理。',
		'男女之间一定有纯友谊，每一个我认识的女生，都说最多只能跟我当朋友。',
		'那些人人羡慕的社会精英，其实过得不如你想象那样好。但肯定比你强得多的多。',
		'哪有什么直男，只要你够好看，都能变成弯的。',
		'哪有什么优柔寡断，还不是因为怂。',
		'哪有什么来日方长，挥手便是人走茶凉。',
		'哪有什么感同身受的心，全是站着说话不腰疼的嘴。',
		'目前最靠谱的发财方法，就是，你家拆迁了。',
		'命只有一条，但要命的事，可不止一件。',
		'明天就要见对方家长了，好忐忑啊，毕竟是我先打的他们家小孩。',
		'明日复明日 明日何其多！既然这么多，不妨再拖拖。',
		'明明可以靠脸吃饭，你却靠才华，这就是你跟明明的差距。',
		'面试的时候，他们叫你去聊聊，真的只是去聊聊。',
		'面对困难，再坚持一会儿，就会习惯的。',
		'梦想还是要有的，万一下辈子实现了呢？',
		'梦想还是要有的，万一见鬼了呢？',
		'梦想还是要有的，不然哪天喝多了，你跟人聊啥？',
		'猛的一看你不怎么样，仔细一看，还不如猛的一看。',
		'妹妹你坐船头，哥哥我在岸上走。看这句的%都是唱出来的。',
		'美貌会消逝，但蠢是永恒的~',
		'每一个抖腿的人，心里都有一台缝纫机。',
		'每天叫醒我的不是理想，是楼下广场舞的音乐。',
		'每天对着镜子说一句你很棒，不久后，那镜子就会成为很棒的镜子。',
		'每天都在勤勤恳恳地，思考一个问题，如何才能不劳而获？',
		'每天都要有新的期待，这样才能有新的失望。',
		'每个女人都在寻找一个爷们，最后发现，最爷们的原来是自己。',
		'每当我找到成功的钥匙，就发现有人把锁芯给换了…',
		'每当我勇敢地走出一步，上帝就会及时慷慨地为我，铺好下一步下坡路。',
		'每次想省钱的时候，就是你智商到达顶峰之时！',
		'每次临时抱佛脚的时候，佛总是给我一脚。',
		'每次看穷游日志的感受都是，那么穷就别TM出去浪了。',
		'每次看你穿丝袜的时候，我都有一种无法言喻的感觉，那就是萝卜还包保鲜膜咧。',
		'每次花钱都说钱包在滴血，可殊不知你的钱包，已经失血过多而死了。',
		'没有什么永垂不朽，但你可以。',
		'没有什么可以将你打败，因为你从未成功过。',
		'没有人瞧不起你，因为根本就没有人瞧你。',
		'没有人能够让你放弃梦想，你自己试试，就会放弃了。',
		'没有人关心你飞得多高，倒是有一群人，等着看你摔得多惨。',
		'没有钱的时候，听到别人说恭祝长命百岁，都觉得是一种诅咒。',
		'没有你想不到，只有你做不到……',
		'没有看不到的消息，只有不想回的人。',
		'没有解决不了的问题，但是有解决不完的问题。',
		'没有，过不去的坎，只有过不完的坎。',
		'没人牵手，我就揣兜。',
		'没人嘲笑你的梦想，他们只是，嘲笑你的实力。',
		'没钱用的时候跟我说，让我知道不止我一个人，没钱用。',
		'没钱了来找我，让我告诉你没钱的日子，怎么过。',
		'没钱才上班还是上班才没钱，我不明白哪个环节出了问题，难道有中间商赚差价？',
		'没对象怕什么，我有对象，我下棋也没赢过啊。',
		'没吃饱只有一种烦恼，吃饱了有无数的烦恼。',
		'买房的钱还没攒完，就要开始攒买坟的钱了。',
		'马云成功跟长相没关系，姜尚成功跟年龄没关系，而成功跟你没关系。',
		'马不停的是蹄，你不停的是嘴。',
		'路遥知马力不足，日久见人心叵测。',
		'路漫漫其修远兮，吾将上下而求人。',
		'领导说努力工作会更快成熟，所以，我现在看上去比他们都老。',
		'领导开会的时候，我们应该保持肃静，打扰别人睡觉是很不礼貌的。',
		'两个人吵架，打他是解决不了问题的，但是解气啊。',
		'恋爱时会觉得像吸毒一样，分手了又会像戒毒一样。',
		'离远一看长发飘飘，走近一看虎背熊腰，转身一看卧槽黑山老妖。',
		'离家不需要太大的勇气，回家才需要。',
		'老一辈的人常告诉我们，年轻的时候多吃点苦，这样老了才能习惯啊！',
		'老天是公平的，他给了你张丑脸，肯定还会给你个穷家。',
		'老师不用给我换座位，反正我坐哪，都聊得开。',
		'老婆饼里没有老婆，棉花糖里没有棉花，所以钱包里也没有钱。',
		'老板用你的时候你就是人才，不用你的时候就变成裁人！',
		'老板说只要我们努力工作，明年他就可以换玛莎拉蒂了。',
		'懒又有目标，才是真的惨。',
		'懒是一个很好的托辞，说的好像你勤奋了就能干成大事一样。',
		'垃圾还有大爷大妈捡走，你呢？',
		'困难也许会迟到，但绝不缺席。',
		'困难像弹簧，你弱它就强，你强它更强。',
		'快去努力吧，以证明自己，智商低。',
		'可以做牛，可以做马，但是千万别做乙方。',
		'可以不劳而获的，只有年纪和脂肪。',
		'可怕的不是，别人在今天忽悠你，而是忘了你这个人。',
		'靠父母你是公主，靠男人你是王妃，靠自己你是乞丐。',
		'考试最崩溃的是看到一道题，模糊的记得老师讲过，但清晰的记得我没听。',
		'考试真是so easy，哪里不会考哪里！',
		'看著面善的，不一定是好人，還有可能是詐騙集團。',
		'看着溅我一身水远去的大奔，劳资心想等我有钱了，一定买一套雨衣。',
		'看时间不是为了起床，而是看还能睡多久。',
		'看见一个算命大师，我刚坐下他就问我，你算什么东西？',
		'看见别人走在成功的路上，你问问自己难道不想成为，他成功路上的绊脚石吗？',
		'看背影迷倒千军万马，转过头吓退百万雄师。',
		'开车我最讨厌两种人，一种是喜欢加塞的人，另一种是不让我加塞的人。',
		'绝望不在某时某刻，而在每时每刻。',
		'距离产生的不是美，而是第三者。',
		'据说到年，要消灭贫困人口，我还不想死。',
		'据分析，造成婚外恋的根本原因，是结婚。',
		'就算是咸鱼，你也不是最咸的那条。',
		'就算是Believe，中间也藏着一个lie。',
		'就算你充电两小时，也不会有人和你通话五分钟。',
		'就算大雨颠覆全城，公司照样算你迟到。',
		'九年义务教育应该开腹语课，毕竟长大后会有太多话，难以启齿。',
		'静若瘫痪，动若癫痫。',
		'精神濒临崩溃的症状之一，就是相信自己的工作非常重要。',
		'经历过一番苦难之后，别人是苦尽甘来，而你是苦竟刚来。',
		'经过十年不断的努力和奋斗，我终于从懵懂无知的少年，变成了懵懂无知的青年。',
		'经过九年的打拼，我终于凑齐了，当年卖掉的那套房子的首付。',
		'经过多年的打拼，虽然没有什么收获，但你有债呀！',
		'经过大家的耐心劝导，我终于接受了，自己是傻逼这个事实。',
		'进入长辈朋友圈，了解最新谣言。',
		'尽量撮合身边的同学，这样可以，少出一笔份子钱。',
		'今晚吃鱼吧，我看你挺会挑刺的。',
		'今天天气很好，在房间里宅久了，准备去客厅散散心。',
		'今天所有的一切，不过是过眼云烟。从明天开始你会一无是处。',
		'今天是除夕夜，来来来，给你夹块你最爱吃的天鹅肉。',
		'今年是过去十年最差的一年，好消息是，今年是之后十年最好的一年。',
		'浆糊不在办公桌上，在你脑子里。',
		'将薪比薪的想了想，算了，不想活了。',
		'见到长辈时，不是我们不想叫他，而是压根就不知道叫他什么。',
		'減肥是一件大事，先讓我吃飽了，再來好好計畫計畫。',
		'减肥这件事情吧，减的快反弹的快，减的慢放弃的快。',
		'减肥就是要向妈妈证明，不光胖找不到对象，瘦也找不到！',
		'减肥，你想要坚持，但坚持不想要你。',
		'间歇性洗心革面，持续性混吃等死。',
		'间歇性踌躇满志，持续性混吃等死。',
		'假如生活欺骗了你，你就打开美颜相机，欺骗所有的人。',
		'假如生活欺骗了你，不要灰心，因为明天也一样',
		'假如生活欺骗了你，不要悲伤不要心急，生活还将继续欺骗你。',
		'假如生活出卖了你，希望是论斤卖，毕竟你比较肥。',
		'假期定了个Plan，半个暑假结束了只完成了P，因为lan。',
		'加我回来吧，我给你发我的婚礼请柬。',
		'既已背影倾天下，何必转身乱芳华。',
		'既没有让人一见钟情的颜，还缺少让人日久生情的钱。',
		'机会是留给有准备的人，没机会的人，就别瞎准备了。',
		'机会，永远留给，有胸有颜的人。',
		'活了这么多年发现，唯一坚持下去的，就是每天给手机充电。',
		'活了这么多年，一直搞不明白一件事，拉钩为什么要上吊？',
		'混到现在，拿得起放得下的，只有筷子。',
		'会有天使替我爱你，那我就去爱别人了。',
		'毁灭友情的方式有许多，最彻底的一种是，借钱不还。',
		'回首过去，我居然没有，走过一次直路。',
		'灰姑娘的鞋若是合脚当初就不会掉，王子若是真的爱灰姑娘就不会连和自己跳了一晚上的舞的女孩都不认识。',
		'欢迎来到，恭喜你进入了新的，扎心的一年。',
		'化再好的妆，也盖不住你，卸妆后的丑。',
		'胡思乱想能瘦身的话，我现在可能已经，只剩下灵魂了。',
		'很久不开QQ，登录后才发现，原来只有腾讯新闻在乎你。',
		'很多时候你不逼自己一把，你都不知道，你还有能把事情搞砸的本事！',
		'很多人觉得自己活得太累，实际上，他们可能只是睡得太晚。',
		'很多次我都觉得坚持不住了，然后我就放弃了。',
		'黑夜给你黑色的眼睛，你却用它来翻白眼。',
		'黑夜从来不会亏待晚睡的人，它会赐予你黑眼圈，和即将猝死的身体。',
		'和对象吵架，先不要追究吵架原因，要弄明白他胆子怎么肥了。',
		'何以解忧，唯有暴富。',
		'好运一定会降临，只是会降临在别人头上。',
		'好想把房子卖了，去环游世界，可惜房东不同意。',
		'好人成佛，需要九九八十一难，坏人只需放下屠刀。',
		'好看的锁骨千篇一律，有趣的肚腩弹来弹去。',
		'好看的皮囊与你无关，有趣的灵魂你又没有。',
		'好看的皮囊现实劈腿，有趣的灵魂精神出轨?。',
		'好看的皮囊三千一晚，有趣的灵魂要车要房。',
		'好看的皮囊千篇一律，有趣的灵魂两百多斤。',
		'好看的皮囊你养不起，有趣的灵魂看不上你',
		'好好过日子吧，每天都会有新打击。',
		'好不容易习惯了自己的长相，理了个发，又换了一种丑法。',
		'海底捞的服务是真心好，上次我吃饭没带钱，还是服务员帮我报的警。',
		'还想过五四青年节，六一儿童节？属于你的只剩下三八节了。',
		'还没有对象？要不要给你介绍，一款不错的狗粮。',
		'还没来得及去沾花惹草，就被人拔光了。',
		'过年哪个亲戚问我成绩，我就问他年终奖金。',
		'过年不吃胖，怎么对得起，死去的鸡鸭鱼猪？',
		'过马路不要带耳机，万一要是被车撞上，耳机不就坏了么？',
		'国庆去哪看风景最好？答案是，朋友圈。',
		'国庆你堵在哪呢?',
		'贵不是iPhone的缺陷，穷是你的缺陷。',
		'恭喜你又熬过一天，还中奖了，再来一天。',
		'工作爱情生活不顺？多照照镜子，很多事情你就明白了。',
		'跟最好的朋友好到什么程度？他进传销，发展的第一个下线就是我。',
		'跟我比懒，你输定了，因为我都懒得跟你比。',
		'跟你谈钱的老板才是好人，跟你谈理想的，都TM不想给你钱！',
		'跟丑这个缺点比，穷根本不值得一提。',
		'根本没有什么高冷的人，人家暖的不是你而已！',
		'给你的梦想插上翅膀，虽然不一定飞得很远，但肯定摔得很重。',
		'给你的梦想插上翅膀，你也飞不到哪里去。',
		'高考失败不要紧，以后还有更多失败等着你。',
		'感谢前行路上击倒我的人，因为，躺着真的好舒服。',
		'感情是可以磨合的，前提是，看脸。',
		'感觉这辈子，最深情绵长的注视，都给了手机。',
		'该失望的事从没辜负过我，每次都认认真真的让我失望。',
		'富人的丁克叫丁克，穷人的丁克叫断子绝孙。',
		'富豪们都在担心税太多，而你只会觉得睡不够！',
		'付出就会有回报，比如一倍的奢望，换两倍的失望。',
		'风水轮流转确实不假，但你在轴心上，这就很尴尬了。',
		'放心吧，只要你持续走下坡路，就永远不会处在人生最低谷。',
		'放心吧 有钱人运气都不会太差的。',
		'放下手机出去走走，最后你会发现，还是手机有意思。',
		'放弃这个字，说起来简单，做起来就更简单了。',
		'放假买个地球仪吧，世界那么大你不但可以看看，还可以转转。',
		'凡是不赚钱的，都说自己在创业。',
		'发丝千万条 睡眠第一条，熬夜不休息 脱发两行泪。',
		'二十年前吃小浣熊，集不齐卡的傻孩子们，依然集不齐五福。',
		'俄罗斯方块教会我们：如果你合群，就会消失。',
		'俄罗斯方块教会了我们，如果你合群，就会消失。',
		'多照照镜子，很多事情你就明白原因了。',
		'蹲下来摸摸自己的影子，对不起，跟着我让你受委屈了。',
		'对于穷人，生活不累的话，那就不叫生活！',
		'对于丑的人来说，细看都是一种残忍。',
		'对象抢不过别人就算了，抢购也抢不过别人，这个光棍节你可咋办。',
		'对女人强吻表白一般会有两种结果，一种是啪，一种是啪啪啪。这就是屌丝和高富帅的差距。',
		'对你竖大拇指的人，不一定是在夸你，也可能是用炮在瞄你。',
		'对你别有用心的人，毕竟也是用心了。 ???',
		'都说谈恋爱会影响学习，难道学习，就不影响谈恋爱吗？',
		'都说钱是王八蛋，可长得真好看。',
		'都说男人有钱就变坏，TMD我都当了，三十多年的好人了！',
		'都说累成狗，其实狗没你那么累。',
		'冬天就是好，穷的时候，还有西北风喝。',
		'冬天床以外的地方都是远方，手够不到的地方都是他乡，上个厕所都是出差。',
		'等你以后老了走不动了，我每天用轮椅推你去广场上，让你看着我和别的老头跳舞。',
		'等到历史考试的时候，历史将会被我改写！',
		'到不了的都叫做远方，回不去的名字叫家乡。',
		'当幸福来敲门的时候，我怕我不在家，所以一直都很宅。',
		'当咸鱼拥有了梦想，它就会成为，一只拥有梦想的咸鱼。',
		'当失去工作动力的时候，就看看银行卡余额吧。之后你就会发现：工作根本没卵用。c',
		'当生活压得你喘不过气，一定要挺直腰杆，这样被压死时才不难看。',
		'当年我背井离乡，乡里人从此再也没有，喝上一口井水。',
		'当你知道自己要去哪里的时候，全世界都在为你添堵。',
		'当你瘦下来之后，你会发现原来你的丑，跟减肥并没有关系。',
		'当你觉得自己不行的时候，就走马路上走走，这样你就是一个行人了。',
		'当你觉得又丑又穷的时候，不要悲伤，至少你的判断还是正确的。',
		'当你怀疑人生的时候，其实这就是你的人生。',
		'当你变得足够优秀的时候，你才发现原来她只是，单纯的不喜欢你。',
		'当初有多感天动地，以后就有多万劫不复。',
		'当别人和你说忙，是TA要留时间，给更重要的人。',
		'单身至今的原因是，熟人不好下手，生人不好开口。',
		'单身脱发又没钱，跑步进入中老年。',
		'单身没有关系，以后单身的日子，还长着呢。',
		'带翅膀的不一定是天使，有可能是雷震子。',
		'大学生啊你要知道，学习不一定能收获，但剁手一定能收货。',
		'大老远看到我一直盯着你时，不要觉得我对你有意思，我真得看不清你是谁。',
		'大家喜欢和你一起，是为了，显示他们的好看。',
		'大家都以为我没有朋友，事实上，我还真没有朋友。',
		'大家都夸我贤惠，闲的什么都不会。',
		'大多数时候，消耗能量的都不是工作，而是工作中遇到的人。',
		'打麻将三缺一，斗地主二缺一，我谈个恋爱咋还一缺一？',
		'打工钱少就出来创业吧，保证能让你，赔个精光。',
		'存款是负的房子是租的，有辆自行车，还是共享的。',
		'从小就喜欢自立，比如靠自己本事单的身。',
		'从小就被教育不要乱花钱，长大后我才发现，根本没钱怎么乱花？',
		'从小到大，唯一不变的，就是一颗不想念书的心。',
		'从今天开始，接受来自三大姑八大姨，灵魂的拷问。',
		'蠢也没那么可怕，毕竟水母没有脑子，也活了亿年。',
		'蠢萌的前提是萌，不是蠢。',
		'春节你要小心了，毕竟过年，都是要杀猪的。',
		'春节假期要结束了，该收收心，准备过五一了。',
		'春节假期，从跳过早午餐开始。',
		'创业嘛就要有个平常心，因为它总是起起落落落落落落的。',
		'传统文化丢失严重啊，古代女子个个能呤诗作对，现代女子不行了 只会作对。',
		'穿白色衣服上班，并不代表你可以不背黑锅。',
		'出身好的努力是为了成功，而你是为了活下去。',
		'出卖自己的灵魂和原则并不丢人，丢人的是没能卖一个好价钱。',
		'出卖灵魂并不丢人，丢人的是，没能卖一个好价钱。',
		'出来混，迟早是要胖的。',
		'丑小鸭能变天鹅，不是因为它多努力，是因为它爸妈本来就是天鹅。',
		'吃完苦中苦，我终于成为了人下人。',
		'吃土的时候，觉得乞丐都比我幸福。',
		'吃货一般都比较善良，因为每天都只想着吃，没有时间去算计别人。',
		'吃货的思路是，好吃你就多吃点，不好吃多少也要吃点。',
		'吃的苦中苦，才知白辛苦。',
		'吃得苦中苦，才知道没有最苦，只有更苦。',
		'承诺就像放屁，当时惊天动地，过后苍白无力。',
		'成长就是将你哭声调成静音的过程。',
		'成年人的世界，除了长胖，其他什么都不容易。',
		'成名就像放的一个屁，响了一声还不够，还要臭段时间。',
		'成功是可以复制的，而对于你，此处禁止粘贴。',
		'成功就像鬼一样，只有别人遇到过。',
		'趁着年轻多出来走走，不然你不会知道，呆在家里有多爽。',
		'趁好看的时候多照照镜子，毕竟，这种错觉不是每天都有的。',
		'车到山前必有雾，船到桥头自然沉。',
		'曾梦想仗剑走天涯，因太胖取消原计划。',
		'曾经我也是靠脸吃饭的，后来差点饿死了…',
		'曾经我想做个特别的人，现在我成功了，我现在特别难过又无助。',
		'曾经是梦想家，现在没了梦，只剩下想家。',
		'曾经给我泼凉水的人，没关系的，我烧开了还会还给你的。',
		'曾经的海枯石烂，抵不过好聚好散。',
		'不知道你越过多少峰才成功，反正你逃不过早晚两个高峰。',
		'不知道，是别人的爱情来的太容易，还是自己的八字太硬。',
		'不用在意别人怎么看你，你在意了，别人也看不上你。',
		'不要总是那么自恋，美女多看了你一眼，只是因为你丑得比较独特。',
		'不要总对人掏心掏肺，有的人不吃内脏。',
		'不要在意现在的低谷，未来还有很长的下坡路要走。',
		'不要再抑郁下去了孩子，你要像一个，神经病一样活泼开朗。',
		'不要再说自己是一条单身狗，其实，你可能比不上狗…',
		'不要再说被骗色了，到你这个年纪来的都是客。',
		'不要以为自己坚持不来，你一定会坚持熬夜玩手机。',
		'不要以为世界抛弃了你，世界根本没空搭理你',
		'不要以为老天在折磨你，而事实上，老天根本就不在意你。',
		'不要太在乎别人的目光，因为没人会注意你。',
		'不要说别人脑子有病，脑子有病的前提是，必须有个脑子。',
		'不要认为你被世界丢弃，只是世界没空搭理你。',
		'不要轻易向命运低头，因为，一低头就会看到赘肉。',
		'不要轻易看不起谁，就算是杀马特，发量都比你多。',
		'不要期待明天，因为明天也不会好过。',
		'不要年纪轻轻，就觉得你已经到了低谷，你还有很大的下降空间。',
		'不要埋怨现在的经历凄惨，跟未来比，还差的远呢。',
		'不要老覺得自己孤單，看看肚子上那圈肥肉，不是從來沒有離開過嘛？',
		'不要放弃你的梦，继续睡！',
		'不要等明天交不上差，再找借口，今天就要找好。',
		'不要担心，一切都是最烂的安排。',
		'不要把自己放的太高了，不然你会不下来的。',
		'不要把银行卡密码，设成女朋友的生日，不然总要换多麻烦。',
		'不笑运气差，一笑脸就大！',
		'不想养狗不想养猫，只想养你，毕竟养猪能致富。',
		'不想谈恋爱是假的，没人要是真的。',
		'不想结婚生子，是我作为穷人的自觉。',
		'不为无益之事，何以遣有涯之生？',
		'不说没人陪你勇闯天涯，你能找到人陪你喝雪花吗？',
		'不是因为看到了希望才坚持，而是因为坚持了，才知道没希望。',
		'不是路不平，而是你不行。',
		'不是大家拿你开玩笑，而是，你就是玩笑本身！',
		'不是吃燕窝的人皮肤好，是吃得起燕窝的人皮肤好。',
		'不是别人瞧不起你，只是别人瞧不见你。',
		'不能老盯着手机屏幕，要不时地抬起头，看看老板的位置。',
		'不明白你们遇到好事，为什么要掐腿揉眼睛，真醒了怎么办？',
		'不就是钱嘛，说得谁不缺似的。',
		'不经历风雨，怎么迎接暴风雨。',
		'不回你消息，不是因为我高冷，而是因为我手冷。',
		'不管是白帽子，还是黑帽子，会变绿的都不是好帽子。',
		'不当家不知柴米贵，不拍照不知自己肥。',
		'不尝试问一次，你怎么知道，你不是爸妈避孕失败的结果？',
		'不逼自己一把，你都不知道，什么叫绝望。',
		'冰冻三尺非一日之寒，小腹三层非一日之馋。',
		'冰冻三尺非一日之寒，掏空钱包却一点不难。',
		'别总自称单身狗了，按年龄你是单身鳖，按智商你是单身傻狍子。',
		'别总是骂别人猪狗，你过的还不如它们。',
		'别再说自己是单身狗了，你这个年纪狗都死了。',
		'别以为世界没了你，没什么区别，没了你地球转得更快。',
		'别以为你一无所有，至少你还有丑！',
		'别一天到晚想着减肥，你的嘴同意你这样想了吗？',
		'别问我有啥，先说你要啥，再说你凭啥。',
		'别问我失败了怎么办，说得好像你成功过一样。',
		'别太自信，你可能信错了人。',
		'别太晚睡，熬夜很伤手机的。',
		'别说自己是单身狗，狗还可以三妻四妾。',
		'白天嘈杂得不愿意醒，夜晚安静得舍不得睡。',
		'把秋衣塞进秋裤，把秋裤塞进棉袜里，是对冬天最起码的尊重。',
		'把女孩子弄哭是很没种的事情，把男孩子弄哭是一件叼爆的事啊。',
		'熬夜对身体不好，建议通宵。',
		'暗恋就是你在心里，为他盖了一座城堡，他却连门都不想进。',
		'暗恋的人没有，想暗杀的倒有一堆。',
		'安慰别人的时候一套一套的，安慰自己的时候，只想找根绳子一套。',
		'爱真的需要勇气，来接受，一次次的没人爱。',
		'爱一个人一定要告诉她，那样你才会知道，她有多讨厌你。',
		'爱笑的女孩运气不会太差，但是运气差的女孩，还能笑得出来吗？',
		'爱笑的姑娘，总是比别人，长更多的鱼尾纹。',
		'爱是一道光，绿到你发慌。',
		'爱情是把双刃剑，一边把你割得很疼，另一边也把你割得很疼。',
		'爱你不是两三天，而是，一天都没有爱过',
		'爱迪生千百次寻觅灯丝，就是为让你，当上耐用的电灯泡。',
		'矮是什么感觉？明明想瞪人的，硬生生成了卖萌。',
		'Follow your heart，翻译成中文就一个字，怂。',
		'18岁以前我穷，但是以后，我会习惯的！'
	] // 可以通过改变数组内容，对名言或诗词进行增删
	c = quoteArr[Math.floor(Math.random() * quoteArr.length)];// 数组中随机取一个元素 
	if (document.getElementById(id)){ document.getElementById(id).placeholder=c; };

	//侧栏跟随
	if($("#sidebar-bottom").size()>0){
		var $elm = $('#sidebar-bottom');
		var startPos = $elm.offset().top;
		$(window).scroll(function() {		  
			var p = $(window).scrollTop();
			if( p > startPos ){
				$elm.css({'position': 'fixed','top': '12px','width': '320px','z-index':'90'});
			}else{
				$elm.css({'position': 'relative'});
			}
		});
	}
	//设置Cookie
	function SetCookie(sName, sValue,iExpireDays) {
		var domainurl = domain2js.domain_url;
		if (iExpireDays){
			var dExpire = new Date();
			dExpire.setTime(dExpire.getTime()+parseInt(iExpireDays*24*60*60*1000));
			document.cookie = sName + "=" + escape(sValue) + "; expires=" + dExpire.toGMTString()+ "; path=/;domain=."+domainurl;
		}
		else{
			document.cookie = sName + "=" + escape(sValue)+ "; path=/;domain=."+domainurl;
		}
	}
	// 目的：返回Cookie
	function GetCookie(sName) {
		var arr = document.cookie.match(new RegExp("(^| )"+sName+"=([^;]*)(;|$)"));
		if(arr !=null){return unescape(arr[2])};
		return null;
	}
	//加载用户信息
	function LoadRememberInfo() {
		var strName=GetCookie("author");
		var strEmail=GetCookie("email");
		var strHomePage=GetCookie("url");
		var bolRemember=GetCookie("chkRemember");
		var a_vlaue= document.getElementById("author");
		if (a_vlaue != null){
			if(bolRemember=="true"){
				//通过decodeURIComponent对内容解码
				if(strName){document.getElementById("author").value=decodeURIComponent(strName);};
				if(strEmail){document.getElementById("email").value=strEmail;};
				//通过decodeURIComponent对内容解码
				if(strHomePage){document.getElementById("url").value=decodeURIComponent(strHomePage);};
				if(bolRemember){document.getElementById("saveme").checked=bolRemember;};
			}
	 
			if(GetCookie("username")){
				document.getElementById("author").value=unescape(GetCookie("username"));
			}
		}
	}
	//保存信息函数
	function SaveRememberInfo() {
		var strName=document.getElementById("author").value;
		var strEmail=document.getElementById("email").value;
		var strHomePage=document.getElementById("url").value;
		var bolRemember=document.getElementById("saveme").checked;
	        //通过encodeURIComponent对内容进行url编码
		SetCookie("author",encodeURIComponent(strName),365);
		SetCookie("email",strEmail,365);
	        //通过encodeURIComponent对内容进行url编码
		SetCookie("url",encodeURIComponent(strHomePage),365);
		SetCookie("chkRemember",bolRemember,365);
	 
	}
	//移除信息函数
	function RemoveRememberInfo() {
		SetCookie("author",'',365);
		SetCookie("email",'',365);
		SetCookie("url",'',365);
		SetCookie("chkRemember",'false',365);
	}
	//通过jQuery ready在页面加载时自动从cookies中载入已保存的用户信息
	$(document).ready(function(){
		LoadRememberInfo();
		//给评论提交按钮绑定信息保存函数
		$("#respond #submit").click(function(){
			SaveRememberInfo();
		});
		//给评论重置按钮绑定信息移除函数
		$("#respond #reset").click(function(){
			RemoveRememberInfo();
		});
	});
// 结束
});