<?php
$this->start('title');
echo $this->Html->titleForLayout(__('About the project'));
$this->end();

$this->start('nav');
$menu[4] = true;
echo $this->element('nav', array('menu' => $menu));
$this->end();
?>

<div class="bg-gray-lighter">
    <div class="container">
        <div class="div-text">
            <h1>О Проекте</h1>
            <p>Представьте, на мгновение, наш мир через каких-то 200 лет. На Земле уже нас нет, как и следующего поколения. И вот вопрос, что о нас смогут рассказать потомки? Для ответа на него, стоит, сперва, задать подобный вопрос самим себе. Что мы сами можем рассказать о наших предках?</p>
            <p>&mdash; Вы знаете чем занимались ваши продедушка и пробабушка? Какова была их жизнь и какими идеалами она была окутана?</p>
            <p>Мы о них, практически, ничего не знаем. По крайней мере, мне о моих мало что известно. А ведь это человеческие жизни наполненные мечтами, стремлением и невзгодами. Это наше недалёкое прошлое о котором мы мало задумываемся.</p>
            <p>Стоит ожидать подобного отношения к нам от наших потомков. Да и что сможет рассказать   неутомимый исследователь своего прошлого, если предки не оставили никаких следов в истории?</p>
            <p>Этот проект создается не только для удовлетворения собственного любопытства к прошлому своего рода, но и стремление аккумулировать эту информацию для будущего.</p>
            <p>Но ни это сподвигло меня заняться генеалогическим древом нашего рода. Мы очень любим, в выходные дни, в тёплой и уютной обстановке, во время чаепития открывать пухлые семейные фотоальбомы и обсуждать истории, запечатлённые на фотокадрах. <?php echo $this->Html->link('Бабай', array('controller' => 'people', 'action' => 'view', 2), array('title' => 'Ахметшин Миргасим Минзахитович')); ?> никогда не упустит момента рассказать о невероятных уловках при получение первого автомобиля Жигули, показывая свои фотографии на фоне этого белого красавца. Он непременно расскажет как поймал большущую рыбу, которая его смогла перехитрить и сорваться с крючка. Конечно, некоторые вещи окажутся преувеличенными, но история от этого не сильно искажается.</p>
            <p>При трагических обстоятельствах, один из фотоальбомов оказался в одной куче с бумагами для топки бани. В один из банных дней, не обратив внимание на это, несчастный альбом, с детскими фотографиями мамы, оказался в самом пекле этой огромной печи. Чудом удалось вытащить обугливший комок слипшихся фотографий и как можно аккуратнее разделить их между собой. В итоге, множество фотокарточек обгорело, представляя из себя одно разочарование.</p>
            <p>Что тут говорить, мне очень жалко эти фотографии. Это печальный урок моей беспечности. Поэтому, я решил не ждать следующей «удачной топки памяти», и занялся оцифровкой семейного фотоальбома. Но я не стал ограничиваться только нашей коллекцией. У бабая и дяди <?php echo $this->Html->link('Рафы', array('controller' => 'people', 'action' => 'view', 10), array('title' => 'Ахметшин Рафаил Миргасимович')); ?> тоже есть свои фотоальбомы, которые непременно нужно сохранить и передать следующим поколениям.</p>
            <p>В итоге, электронный альбом состоит из более 950 фотографий и постоянно пополняется. Вне зависимости от даты съёмки и качества самих фотографий, всё сохраняется в единой коллекции.</p>
            <p>Хотелось бы отметить, что в этой коллекции собраны фотографии множества родственных семей, а именно: Ахметшиных, Галиулиных, Гайнулиных, Даллиных, Кутпановых, Хафазовых, Хайрутдиновых и многих других. Чтобы отыскать себя в этой большой коллекции, я внедрил систему отметки людей на фотографиях. Это позволяет видеть все фотографии, на которых <?php echo $this->Html->link('вы отмечены', array('controller' => 'marks', 'action' => 'index'), array('title' => 'Вас отметили')); ?>.</p>
            <p>Также организовано генеалогическое древо, которое требует более широкого наполнения. В данный момент, в нём отмечены люди, фотографии которых имеются в наличии, либо эти люди необходимы для объединения соседствующих ветвей. По воспоминаниям бабая, стараюсь делать заметки о жизни наших предков, которые дают хоть какое-то представление о нашем прошлом.</p>
            <p>Я приветствую всех гостей и, надеюсь, вам хоть чуточку будут интересны мои начинания.</p>
            <p>С уважением, <?php echo $this->Html->link('Марат', array('controller' => 'people', 'action' => 'view', 1), array('title' => 'Ахметшин Марат Ренатович')); ?>.</p>
            <br/>
            <p>_________</p>
            <p>P.S. Вы также можете ознакомиться со всеми <?php echo $this->Html->link('функциями', array('controller' => 'pages', 'action' => 'func'), array('title' => 'Функционал сайта')); ?> и <?php echo $this->Html->link('техническими характеристиками', array('controller' => 'pages', 'action' => 'tech'), array('title' => 'Технические характеристики сайта')); ?> сайта.</p>
        </div>
    </div>
</div>