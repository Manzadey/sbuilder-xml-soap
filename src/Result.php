<?php

namespace Manzadey\SbuilderXmlSoap;

class Result
{
    const CODE_ERRORS = [
        1    => 'Раздел успешно изменен.',
        2    => 'Раздел успешно добавлен.',
        3    => 'Элемент успешно добавлен/изменен.',
        4    => 'Ссылка на элемент X в разделе Y успешно добавлена.',
        5    => 'Элемент X успешно удален.',
        6    => 'Раздел Y успешно удален.',
        1001 => 'Предупреждение! У Вас нет прав на редактирование раздела. См. п.1.2',
        1002 => 'Предупреждение! Невозможно добавить раздел, т.к. не добавлен родительский раздел. См. п.1.2',
        1003 => 'Предупреждение! Невозможно добавить элемент, т.к. не добавлен родительский раздел. См. п.1.2',
        1004 => 'Предупреждение! Невозможно изменить раздел, т.к. у Вас нет прав на редактирование этого раздела. См. п.1.2',
        1005 => 'Предупреждение! Невозможно добавить/изменить элемент, т.к. не удалось определить родительский раздел.',
        1006 => 'Предупреждение! Невозможно изменить элемент, т.к. у Вас нет прав на редактирование родительского раздела. См. п.1.2',
        1007 => 'Предупреждение! Невозможно переместить элемент X, т.к. у Вас нет прав на редактирование раздела Y. См. п.1.2',
        1008 => 'Предупреждение! Невозможно добавить/изменить элемент (Возможно неверный xml). См. п.2; п.3.2.2',
        1009 => 'Предупреждение! Невозможно создать ссылку на элемент X в разделе Y, т.к. у Вас нет прав на редактирование раздела Y. См. п.1.2',
        1010 => 'Предупреждение! Невозможно изменить поле X раздела Y, т.к. у Вас нет прав на редактирование этого поля. См. п.1.3',
        1011 => 'Предупреждение! Невозможно добавить/изменить раздел.',
        1012 => 'Предупреждение! Невозможно создать ссылку на элемент X в разделе Y. См. п.1.2',
        1013 => 'Предупреждение! Невозможно удалить раздел Y. Возможно раздел, или его подразделы содержат элементы',
        1014 => 'Предупреждение! Невозможно удалить элемент X, т.к. не задан идентификатор',
        1015 => 'Предупреждение! Невозможно удалить элемент.',
        1016 => 'Предупреждение! Невозможно удалить раздел Y, т.к. не задан идентификатор.',
        1017 => 'Предупреждение! У Вас нет прав на удаления элементов модуля.',
        1018 => 'Предупреждение! У Вас нет прав на удаления разделов модуля.',
        1019 => 'Предупреждение! Невозможно изменить поле элемента, т.к. неверно задан внешний идентификатор справочника.',
        1020 => 'Предупреждение! Невозможно изменить поле раздела, т.к. неверно задан внешний идентификатор справочника.',
        1021 => 'Предупреждение! Неизвестное поле X в элементе модуля M.',
        1022 => 'Предупреждение! Неизвестное X в разделе модуля M',
        1023 => 'Предупреждение! Невозможно добавить/изменить раздел в модуле M, т.к. не задано название раздела',
        2002 => 'Ошибка! Вы передали неверный soap token. См. п.1.4; п.3.2.2',
        2003 => 'Ошибка! Вы передали устаревший soap token. См. п.1.4; п.3.2.2 (Если у пользователя менялся логин или пароль, нужно перегенирировать секретный ключ. См. п.1.4)',
        2004 => 'Ошибка! Вы не передали XML код. См. п.2; п.3.2.2',
        2005 => 'Ошибка! Ваша учетная запись заблокирована администратором системы.',
        2006 => 'Ошибка! У Вас нет прав на администрирование домена.',
        2007 => 'Ошибка! Вход в систему с Вашего IP-адреса запрещен.',
        2008 => 'Ошибка! Группа пользователей, в которую входит Ваша учетная запись, заблокирована администратором системы.',
        2009 => 'Ошибка! Вы передали неверный xml код. См. п.2',
        2010 => 'Ошибка! У Вас нет прав на редактирование разделов модуля. См. п.1.1',
    ];

    /**
     * @var string
     */
    protected $result;

    /**
     * @var array[]
     */
    protected $messages = [];

    /**
     * Result constructor.
     *
     * @param string $result
     */
    public function __construct($result)
    {
        $this->result = $result;
        $this->setUpMessages();
    }

    /**
     * @return string
     */
    public function getRawResult()
    {
        return $this->result;
    }

    private function setUpMessages()
    {
        $dom = new \DOMDocument;
        $dom->loadXML($this->result);

        $domMessages = $dom->getElementsByTagName('sbmessage');

        /* @var \DOMElement $message */
        foreach ($domMessages as $i => $message) {
            $this->messages[$i] = [
                'message'     => strip_tags($message->nodeValue),
                'code'        => $code = (int) $message->attributes->getNamedItem('code')->nodeValue,
                'codeMessage' => isset(self::CODE_ERRORS[$code]) ? self::CODE_ERRORS[$code] : null,
            ];
        }
    }

    /**
     * @return array[]
     */
    public function messages()
    {
        return $this->messages;
    }

    /**
     * @param int $code
     */
    public function getMessagesByCode($code)
    {
        $messages = [];

        foreach ($this->messages as $message) {
            if($message['code'] === (string) $code) {
                $messages[] = $message;
            }
        }

        return $messages;
    }

    /**
     * @return array[]
     */
    public function getWarnings()
    {
        $messages = [];

        foreach ($this->messages as $message) {
            if($message['code'] > 1000 && $message['code'] < 2000) {
                $messages[] = $message;
            }
        }

        return $messages;
    }

    /**
     * @return array[]
     */
    public function getErrors()
    {
        $messages = [];

        foreach ($this->messages as $message) {
            if($message['code'] > 2000 && $message['code'] < 3000) {
                $messages[] = $message;
            }
        }

        return $messages;
    }

    /**
     * @return array[]
     */
    public function getSuccesses()
    {
        $messages = [];

        foreach ($this->messages as $message) {
            if($message['code'] >= 1 && $message['code'] < 1000) {
                $messages[] = $message;
            }
        }

        return $messages;
    }
}
