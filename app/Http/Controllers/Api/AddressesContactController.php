<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\AddressesContact\AddressesContactResponseData;
use App\DataTransferObjects\AddressesContact\AddressesContactsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressesContactRequest;
use App\Models\AddressesContact;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressesContactController extends Controller
{
    protected $model = AddressesContact::class;
    protected $translatePath = 'controller.addressesContact';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $addressesContacts = $this->model::paginate();

        return new ResponsePaginationData([
            'paginator' => $addressesContacts,
            'collection' => new AddressesContactsCollection(['collection' => $addressesContacts->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return AddressesContactResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): AddressesContactResponseData|NotFoundHttpException
    {
        try {
            $addressesContact = $this->model::findOrFail($id);

            return new AddressesContactResponseData(['addressesContact' => $addressesContact, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param AddressesContactRequest $request
     * @return AddressesContactResponseData
     * @throws UnknownProperties
     */
    public function create(AddressesContactRequest $request): AddressesContactResponseData
    {
        $addressesContact = $this->model::create($request->all());

        return new AddressesContactResponseData(['addressesContact' => $addressesContact, 'message' => __($this->translatePath . '.create')]);
    }

    /**
     * @param AddressesContactRequest $request
     * @param int $id
     * @return AddressesContactResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(AddressesContactRequest $request, int $id): AddressesContactResponseData|NotFoundHttpException
    {
        try {
            /** @var AddressesContact $addressesContact */
            $addressesContact = $this->model::findOrFail($id);
            $addressesContact->address_id = $request->address_id ?? $addressesContact->address_id;
            $addressesContact->type = $request->type ?? $addressesContact->type;
            $addressesContact->value = $request->value ?? $addressesContact->value;
            $addressesContact->description = $request->description ?? $addressesContact->description;
            $addressesContact->save();

            return new AddressesContactResponseData(['addressesContact' => $addressesContact, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
