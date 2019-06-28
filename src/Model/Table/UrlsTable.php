<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use ArrayObject;

use App\Model\Entity\Url;

/**
 * Urls Model
 *
 * @method \App\Model\Entity\Url get($primaryKey, $options = [])
 * @method \App\Model\Entity\Url newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Url[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Url|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Url saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Url patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Url[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Url findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UrlsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('urls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->provider('url', 'App\Model\Validation\Url');
        $validator
            ->add('long_url', 'exists', [
                'rule' => 'urlExists',
                'provider' => 'url',
                'message' => __('This must be an existing URL'),
            ]);

        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->url('long_url', __('This must be a valid URL'))
            ->scalar('long_url')
            ->maxLength('long_url', 255)
            ->requirePresence('long_url', 'create')
            ->allowEmptyString('long_url', false)
            ->add('long_url', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
            ]);

        $validator
            ->scalar('short_url')
            ->maxLength('short_url', 10)
            ->allowEmptyString('short_url', false);

        $validator
            ->integer('visits')
            ->allowEmptyString('visits', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['long_url']));

        return $rules;
    }

    /**
     * Calls the setShortUrl method.
     *
     * @param \Cake\Event\Event $event The fired event.
     * @param \Cake\Datasource\EntityInterface $url The created URL.
     * @param \ArrayObject $options Saving options.
     */
    public function afterSave(Event $event, EntityInterface $url, ArrayObject $options)
    {
        $this->setShortUrl($url);
    }

    /**
     * Increments the vists of a given url entity and saves the changes.
     *
     * @param \App\Model\Entity\Url $url The URL to be modified.
     * @return void
     */
    public function incrementVisits(Url $url)
    {
        $url->incrementVisits();
        $this->save($url);
    }

    /**
     * Sets the short url if the record was just created.
     *
     * @param \App\Model\Entity\Url $url The created URL.
     * @return void
     */
    protected function setShortUrl(Url $url)
    {
        if (!$url->isShortUrlSet()) {
            $url->setShortUrl();
            $this->save($url);
        }
    }
}
